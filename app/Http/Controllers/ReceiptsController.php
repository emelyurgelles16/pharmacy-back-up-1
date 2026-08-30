<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\DiscountType;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Setting;

class ReceiptsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $userRole = $user->roles->first()->name ?? 'cashier';
        
        $query = Sale::with(['user', 'discountType'])
                    ->orderBy('created_at', 'desc');
        
        if ($request->has('search')) {
            $query->where('invoice_no', 'like', "%{$request->search}%");
        }
        
        if ($request->has('customer_type') && $request->customer_type != 'all') {
            $query->where('customer_type', $request->customer_type);
        }
        
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }
        
        $sales = $query->paginate(20);
        
        $selectedSale = null;
        if ($request->has('selected')) {
            $selectedSale = Sale::with(['user', 'discountType'])
                               ->find($request->selected);
        } elseif ($sales->count() > 0) {
            $selectedSale = $sales->first();
        }
        
        $discountTypes = DiscountType::where('is_active', true)->get();
        
        $pharmacy = [
            'name' => Setting::get('pharmacy_name', 'ALPHAMED PHARMACY'),
            'address' => Setting::get('pharmacy_address', 'Brgy: San Juan, Manila City'),
            'contact' => Setting::get('pharmacy_contact', ''),
            'email' => Setting::get('pharmacy_email', ''),
            'tin' => Setting::get('pharmacy_tin', '123-456-789-000'),
            'logo' => Setting::get('pharmacy_logo', ''),
        ];

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'view_receipts',
            'Receipts',
            'Viewed receipt history - ' . $sales->total() . ' receipts found',
            'Success'
        );
        
        return view('receipts.index', compact('sales', 'selectedSale', 'discountTypes', 'userRole', 'pharmacy'));
    }
    
    public function printReceipt($id)
    {
        $sale = Sale::with(['user', 'discountType', 'items.product'])->findOrFail($id);
        
        $pharmacy = [
            'name' => Setting::get('pharmacy_name', ''),
            'address' => Setting::get('pharmacy_address', ''),
            'contact' => Setting::get('pharmacy_contact', ''),
            'email' => Setting::get('pharmacy_email', ''),
            'tin' => Setting::get('pharmacy_tin', ''),
            'logo' => Setting::get('pharmacy_logo', ''),
        ];

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'print_receipt',
            'Receipts',
            'Printed receipt for Invoice #' . $sale->invoice_no . ' - Total: ₱' . number_format($sale->total_amount, 2),
            'Success'
        );
        
        return view('receipts.print', compact('sale', 'pharmacy'));
    }
}