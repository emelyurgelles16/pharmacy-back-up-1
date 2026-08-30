<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockQueue;
use App\Models\ProductBatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;
use App\Models\DosageForm;

class InventoryController extends Controller
{

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'old-stock');
        $categories = Category::all();
        $dosageForms = DosageForm::where('is_active', true)->orderBy('name')->get();

        if ($tab == 'old-stock') {
            $products = Product::with('batches')->get();
            
            return view('inventory', [
                'products' => $products,
                'tab' => $tab,
                'categories' => $categories,
                'dosageForms' => $dosageForms,
                'queuedStocks' => StockQueue::where('status', 'in_queue')->with('addedByUser')->get()
            ]);
        } else {
            $queuedStocks = StockQueue::where('status', 'in_queue')->with(['product', 'addedByUser'])->get();
            
            return view('inventory', [
                'products' => Product::with('batches')->get(),
                'tab' => $tab,
                'categories' => $categories,
                'dosageForms' => $dosageForms,
                'queuedStocks' => $queuedStocks
            ]);
        }
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::all();
        $dosageForms = DosageForm::where('is_active', true)->orderBy('name')->get();
        return view('products.create', compact('categories', 'dosageForms'));
    }

    public function store(Request $request)
    {
        \Log::info('=== STORE METHOD CALLED ===');
        \Log::info('Request data:', $request->all());
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'barcode' => 'nullable|string|max:50|unique:products,barcode',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1',
                'pieces_per_box' => 'required|integer|min:1',
                'arrival_date' => 'required|date',
                'dosage_amount' => 'required|numeric|min:0',
                'dosage_unit' => 'required|string|in:mg,ml,g,L',
                'brand' => 'nullable|string|max:255',
                'form' => 'nullable|string|in:Tablet,Capsule,Syrup,Drops,Ointment,Injection',
                'type' => 'nullable|string|in:Generic,Branded',
                'category' => 'nullable|string|max:255',
                'expiry_date' => 'nullable|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            DB::beginTransaction();
            
            $barcode = $request->barcode ?? Product::generateBarcode();
            
            $existingProduct = Product::where('name', $request->name)
                ->where('brand', $request->brand ?? '')
                ->where('dosage_amount', $request->dosage_amount)
                ->where('dosage_unit', $request->dosage_unit)
                ->where('form', $request->form ?? '')
                ->where('type', $request->type ?? '')
                ->first();
            
            $totalPieces = $request->quantity * $request->pieces_per_box;
            
            if ($existingProduct) {
                if ($request->barcode && $request->barcode !== $existingProduct->barcode) {
                    $barcodeExists = Product::where('barcode', $request->barcode)->exists();
                    if ($barcodeExists) {
                        throw new \Exception('Barcode already exists in another product.');
                    }
                }
                
                $hasActiveStock = $existingProduct->batches()
                    ->where('pieces_left', '>', 0)
                    ->where(function($q) {
                        $q->where('expiry_date', '>', now())
                          ->orWhereNull('expiry_date');
                    })
                    ->exists();
                
                $nextBatchNumber = 'Batch ' . ($existingProduct->batches()->count() + 1);
                
                if ($hasActiveStock) {
                    $queueStock = StockQueue::create([
                        'product_id' => $existingProduct->id,
                        'product_name' => $request->name,
                        'barcode' => $request->barcode ?? $existingProduct->barcode,
                        'brand' => $request->brand,
                        'dosage_amount' => $request->dosage_amount,
                        'dosage_unit' => $request->dosage_unit,
                        'form' => $request->form,
                        'type' => $request->type,
                        'category' => $request->category,
                        'price' => $request->price,
                        'quantity' => $request->quantity,
                        'pieces_per_box' => $request->pieces_per_box,
                        'total_pieces' => $totalPieces,
                        'expiry_date' => $request->expiry_date,
                        'arrival_date' => $request->arrival_date,
                        'added_by' => auth()->id(),
                        'status' => 'in_queue',
                    ]);
                    
                    DB::commit();
                    
                    ActivityLog::log(
                        auth()->id(),
                        auth()->user()->username,
                        'add_stock_queue',
                        'Inventory',
                        'Added stock to QUEUE for existing product: ' . $request->name . ' - ' . $request->quantity . ' boxes (' . $nextBatchNumber . ')',
                        'Success'
                    );
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Product added to QUEUE as ' . $nextBatchNumber . '!',
                        'queue_id' => $queueStock->id,
                        'batch_number' => $nextBatchNumber,
                        'in_queue' => true
                    ]);
                } else {
                    $batch = ProductBatch::create([
                        'product_id' => $existingProduct->id,
                        'quantity' => $request->quantity,
                        'pieces_per_box' => $request->pieces_per_box,
                        'pieces_left' => $totalPieces,
                        'total_pieces' => $totalPieces,
                        'expiry_date' => $request->expiry_date,
                        'arrival_date' => $request->arrival_date,
                        'batch_number' => $nextBatchNumber,
                    ]);
                    
                    DB::commit();
                    
                    ActivityLog::log(
                        auth()->id(),
                        auth()->user()->username,
                        'add_stock',
                        'Inventory',
                        'Added stock to INVENTORY for existing product: ' . $request->name . ' - ' . $request->quantity . ' boxes (' . $nextBatchNumber . ')',
                        'Success'
                    );
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Stock added to OLD STOCK as ' . $nextBatchNumber . '!',
                        'batch_id' => $batch->id,
                        'batch_number' => $nextBatchNumber,
                        'in_queue' => false
                    ]);
                }
            } else {
                $imagePath = null;
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('products', 'public');
                }
                
                $product = Product::create([
                    'name' => $request->name,
                    'barcode' => $barcode,
                    'brand' => $request->brand,
                    'dosage_amount' => $request->dosage_amount,
                    'dosage_unit' => $request->dosage_unit,
                    'form' => $request->form,
                    'type' => $request->type,
                    'category' => $request->category,
                    'price' => $request->price,
                    'image' => $imagePath,
                ]);
                
                $batch = ProductBatch::create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'pieces_per_box' => $request->pieces_per_box,
                    'pieces_left' => $totalPieces,
                    'total_pieces' => $totalPieces,
                    'expiry_date' => $request->expiry_date,
                    'arrival_date' => $request->arrival_date,
                    'batch_number' => 'Batch 1',
                ]);
                
                DB::commit();
                
                ActivityLog::log(
                    auth()->id(),
                    auth()->user()->username,
                    'add_medicine',
                    'Inventory',
                    'Added new medicine: ' . $request->name . ' - ' . $request->quantity . ' boxes (Batch 1)',
                    'Success'
                );
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'New product created in OLD STOCK as Batch 1!',
                    'product_id' => $product->id,
                    'batch_id' => $batch->id,
                    'batch_number' => 'Batch 1',
                    'in_queue' => false
                ]);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            \Log::error('Validation Error:', $e->errors());
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Store error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing a product
     */
    public function edit($id)
    {
        $product = Product::with('batches')->findOrFail($id);
        $categories = Category::all();
        $dosageForms = DosageForm::where('is_active', true)->orderBy('name')->get();
        $batch = $product->batches->first();
        
        return view('products.edit', compact('product', 'categories', 'dosageForms', 'batch'));
    }

    /**
     * UPDATE PRODUCT - Returns JSON for AJAX
     */
    public function update(Request $request, $id)
    {
        try {
            \Log::info('=== UPDATE METHOD CALLED ===');
            \Log::info('Product ID: ' . $id);
            \Log::info('Request data:', $request->all());
            
            // ✅ CHECK IF PRODUCT EXISTS
            $product = Product::find($id);
            if (!$product) {
                \Log::error('Product not found: ' . $id);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found.'
                ], 404);
            }
            \Log::info('Product found: ' . $product->name);
            
            // ✅ VALIDATION WITH CUSTOM MESSAGES
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'barcode' => 'nullable|string|max:50|unique:products,barcode,' . $id,
                'brand' => 'nullable|string|max:255',
                'dosage_amount' => 'required|numeric|min:0',
                'dosage_unit' => 'required|string|in:mg,ml,g,L',
                'form' => 'nullable|string|in:Tablet,Capsule,Syrup,Drops,Ointment,Injection,Liquid,Powder,Cream,Gel,Spray,Inhaler,Other',
                'type' => 'required|string|in:Generic,Branded',
                'category' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1',
                'pieces_per_box' => 'required|integer|min:1',
                'expiry_date' => 'nullable|date',
                'arrival_date' => 'nullable|date',
                'batch_id' => 'nullable|exists:product_batches,id',
                'remove_image' => 'nullable|boolean',
            ], [
                'name.required' => 'Product Name is required.',
                'name.max' => 'Product Name cannot exceed 255 characters.',
                'barcode.unique' => 'This barcode is already used by another product.',
                'dosage_amount.required' => 'Dosage amount is required.',
                'dosage_amount.numeric' => 'Dosage amount must be a valid number.',
                'dosage_unit.required' => 'Dosage unit is required.',
                'dosage_unit.in' => 'Dosage unit must be mg, ml, g, or L.',
                'type.required' => 'Type (Generic/Branded) is required.',
                'type.in' => 'Type must be either Generic or Branded.',
                'category.required' => 'Category is required.',
                'price.required' => 'Price is required.',
                'price.numeric' => 'Price must be a valid number.',
                'price.min' => 'Price cannot be negative.',
                'quantity.required' => 'Quantity is required.',
                'quantity.integer' => 'Quantity must be a whole number.',
                'quantity.min' => 'Quantity must be at least 1.',
                'pieces_per_box.required' => 'Pieces per box is required.',
                'pieces_per_box.integer' => 'Pieces per box must be a whole number.',
                'pieces_per_box.min' => 'Pieces per box must be at least 1.',
                'expiry_date.date' => 'Expiry date must be a valid date.',
                'arrival_date.date' => 'Arrival date must be a valid date.',
                'batch_id.exists' => 'Selected batch does not exist.',
            ]);
            \Log::info('Validation passed');
            
            DB::beginTransaction();
            \Log::info('Transaction started');
            
            // ✅ UPDATE PRODUCT
            $oldName = $product->name;
            $oldPrice = $product->price;
            $oldCategory = $product->category;
            $oldImage = $product->image;
            
            $changes = [];
            if ($oldName != $request->name) $changes[] = "Name: $oldName → {$request->name}";
            if ($oldPrice != $request->price) $changes[] = "Price: ₱$oldPrice → ₱{$request->price}";
            if ($oldCategory != $request->category) $changes[] = "Category: $oldCategory → {$request->category}";
            
            $product->update([
                'name' => $request->input('name'),
                'barcode' => $request->input('barcode'),
                'brand' => $request->input('brand'),
                'dosage_amount' => $request->input('dosage_amount'),
                'dosage_unit' => $request->input('dosage_unit'),
                'form' => $request->input('form'),
                'type' => $request->input('type'),
                'category' => $request->input('category'),
                'price' => $request->input('price'),
            ]);
            \Log::info('Product updated: ' . $product->name);
            
            // ✅ HANDLE IMAGE
            if ($request->hasFile('image')) {
                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                    \Log::info('Old image deleted: ' . $oldImage);
                }
                $path = $request->file('image')->store('products', 'public');
                $product->update(['image' => $path]);
                \Log::info('New image uploaded: ' . $path);
                $changes[] = "Image: Updated";
            }
            
            // ✅ HANDLE REMOVE IMAGE
            if ($request->has('remove_image') && $request->remove_image == '1') {
                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                    $product->update(['image' => null]);
                    \Log::info('Image removed');
                    $changes[] = "Image: Removed";
                }
            }
            
            // ✅ UPDATE BATCH
            $batchId = $request->input('batch_id');
            $batchChanges = [];
            if ($batchId) {
                $batch = ProductBatch::find($batchId);
                if ($batch) {
                    $oldQuantity = $batch->quantity;
                    $oldPiecesPerBox = $batch->pieces_per_box;
                    $oldTotalPieces = $batch->total_pieces;
                    $oldPiecesLeft = $batch->pieces_left;
                    $oldExpiry = $batch->expiry_date;
                    $oldArrival = $batch->arrival_date;
                    
                    $newTotalPieces = $request->quantity * $request->pieces_per_box;
                    
                    $newPiecesLeft = $oldPiecesLeft;
                    
                    if ($oldPiecesLeft == $oldTotalPieces) {
                        $newPiecesLeft = $newTotalPieces;
                    } else if ($oldPiecesLeft < $oldTotalPieces && $oldTotalPieces > 0) {
                        $remainingRatio = $oldPiecesLeft / $oldTotalPieces;
                        $newPiecesLeft = (int) round($newTotalPieces * $remainingRatio);
                        if ($newPiecesLeft > $newTotalPieces) {
                            $newPiecesLeft = $newTotalPieces;
                        }
                    }
                    
                    if ($newPiecesLeft > $newTotalPieces) {
                        $newPiecesLeft = $newTotalPieces;
                    }
                    
                    $batchData = [
                        'quantity' => $request->quantity,
                        'pieces_per_box' => $request->pieces_per_box,
                        'total_pieces' => $newTotalPieces,
                        'pieces_left' => $newPiecesLeft,
                        'expiry_date' => $request->expiry_date,
                    ];
                    
                    if ($request->has('arrival_date') && $request->arrival_date) {
                        $batchData['arrival_date'] = $request->arrival_date;
                    }
                    
                    $batch->update($batchData);
                    \Log::info('Batch updated: ' . $batch->id);
                    
                    if ($oldQuantity != $request->quantity) {
                        $batchChanges[] = "Quantity: $oldQuantity → {$request->quantity} boxes";
                    }
                    if ($oldPiecesPerBox != $request->pieces_per_box) {
                        $batchChanges[] = "Pcs/Box: $oldPiecesPerBox → {$request->pieces_per_box}";
                    }
                    if ($oldTotalPieces != $newTotalPieces) {
                        $batchChanges[] = "Total Pieces: $oldTotalPieces → $newTotalPieces";
                    }
                    if ($oldPiecesLeft != $newPiecesLeft) {
                        $batchChanges[] = "Pcs Left: $oldPiecesLeft → $newPiecesLeft";
                    }
                    if ($oldExpiry != $request->expiry_date) {
                        $batchChanges[] = "Expiry: " . ($oldExpiry ?? 'N/A') . " → {$request->expiry_date}";
                    }
                    if ($request->has('arrival_date') && $request->arrival_date && $oldArrival != $request->arrival_date) {
                        $batchChanges[] = "Arrival: " . ($oldArrival ?? 'N/A') . " → {$request->arrival_date}";
                    }
                } else {
                    \Log::warning('Batch not found: ' . $batchId);
                }
            }
            
            DB::commit();
            \Log::info('Transaction committed');
            
            $changeLog = !empty($changes) ? implode(', ', $changes) : 'No changes';
            $batchChangeLog = !empty($batchChanges) ? ' | Batch: ' . implode(', ', $batchChanges) : '';
            
            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'update_medicine',
                'Inventory',
                'Updated medicine: ' . $oldName . ' (ID: ' . $id . ') - Changes: ' . $changeLog . $batchChangeLog,
                'Success'
            );
            
            // ✅ RETURN JSON RESPONSE FOR AJAX
            return response()->json([
                'status' => 'success',
                'message' => '✅ Product updated successfully!'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            \Log::error('Validation Error:', $e->errors());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Update error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $batch = ProductBatch::find($id);
            
            if ($batch) {
                $productName = $batch->product ? $batch->product->name : 'Unknown';
                $batchNumber = $batch->batch_number;
                $batch->delete();
                
                $product = Product::find($batch->product_id);
                if ($product && $product->batches()->count() == 0) {
                    if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
                        unlink(storage_path('app/public/' . $product->image));
                    }
                    $product->delete();
                    
                    ActivityLog::log(
                        auth()->id(),
                        auth()->user()->username,
                        'delete_medicine',
                        'Inventory',
                        'Deleted medicine: ' . $productName . ' (all batches)',
                        'Success'
                    );
                } else {
                    ActivityLog::log(
                        auth()->id(),
                        auth()->user()->username,
                        'delete_batch',
                        'Inventory',
                        'Deleted batch: ' . $batchNumber . ' from product: ' . $productName,
                        'Success'
                    );
                }
                
                DB::commit();
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Batch deleted successfully'
                ]);
            } else {
                $product = Product::findOrFail($id);
                $productName = $product->name;
                $product->batches()->delete();
                
                if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
                    unlink(storage_path('app/public/' . $product->image));
                }
                
                $product->delete();
                
                DB::commit();
                
                ActivityLog::log(
                    auth()->id(),
                    auth()->user()->username,
                    'delete_medicine',
                    'Inventory',
                    'Deleted medicine: ' . $productName . ' (ID: ' . $id . ')',
                    'Success'
                );
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product deleted successfully'
                ]);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $batch = ProductBatch::with('product')->find($id);
            
            if ($batch) {
                $batchData = $batch->toArray();
                if ($batch->expiry_date) {
                    $batchData['expiry_date'] = $batch->expiry_date->format('Y-m-d');
                }
                if ($batch->arrival_date) {
                    $batchData['arrival_date'] = $batch->arrival_date->format('Y-m-d');
                }
                
                return response()->json([
                    'type' => 'batch',
                    'batch' => $batchData,
                    'product' => $batch->product
                ]);
            }
            
            $product = Product::with('batches')->find($id);
            
            if ($product) {
                return response()->json([
                    'type' => 'product',
                    'product' => $product,
                    'batches' => $product->batches
                ]);
            }
            
            return response()->json([
                'type' => 'error',
                'message' => 'Record not found'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deduct(Request $request, $productId)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            $product = Product::with(['batches' => function($query) {
                $query->where('pieces_left', '>', 0)
                      ->orderBy('expiry_date', 'asc')
                      ->orderBy('arrival_date', 'asc');
            }])->findOrFail($productId);

            $remainingPieces = $request->amount;
            $batchesUsed = [];

            foreach ($product->batches as $batch) {
                if ($remainingPieces <= 0) break;
                
                $piecesTaken = min($batch->pieces_left, $remainingPieces);
                
                $batch->pieces_left -= $piecesTaken;
                $batchesUsed[] = [
                    'batch_id' => $batch->id,
                    'batch_number' => $batch->batch_number,
                    'expiry_date' => $batch->expiry_date ? $batch->expiry_date->format('Y-m-d') : 'No expiry',
                    'arrival_date' => $batch->arrival_date ? $batch->arrival_date->format('Y-m-d') : 'Unknown',
                    'pieces_taken' => $piecesTaken,
                    'pieces_left' => $batch->pieces_left
                ];
                $remainingPieces -= $piecesTaken;
                
                if ($batch->pieces_left == 0) {
                    $batch->quantity = 0;
                } else {
                    $batch->quantity = ceil($batch->pieces_left / $batch->pieces_per_box);
                }
                
                $batch->save();
            }

            $batchDetails = [];
            foreach ($batchesUsed as $batch) {
                $batchDetails[] = "Batch {$batch['batch_number']} (Exp: {$batch['expiry_date']}): {$batch['pieces_taken']} pcs";
            }
            
            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'deduct_stock',
                'Inventory',
                'Deducted ' . $request->amount . ' pieces from ' . $product->name . ' - Batches used: ' . implode(', ', $batchDetails),
                'Success'
            );

            $totalPiecesLeft = $product->batches()->where('pieces_left', '>', 0)->sum('pieces_left');
            
            if ($totalPiecesLeft <= 0) {
                $queuedStock = StockQueue::where('product_id', $product->id)->first();
                
                if ($queuedStock) {
                    \Log::info('Stock is empty. Auto-transferring from queue for product: ' . $product->name);
                    
                    $nextBatchNumber = 'Batch ' . ($product->batches()->count() + 1);
                    $totalPieces = $queuedStock->quantity * $queuedStock->pieces_per_box;
                    
                    ProductBatch::create([
                        'product_id' => $product->id,
                        'quantity' => $queuedStock->quantity,
                        'pieces_per_box' => $queuedStock->pieces_per_box,
                        'pieces_left' => $totalPieces,
                        'total_pieces' => $totalPieces,
                        'expiry_date' => $queuedStock->expiry_date,
                        'arrival_date' => $queuedStock->arrival_date,
                        'batch_number' => $nextBatchNumber,
                    ]);
                    
                    $queuedStock->delete();
                    
                    ActivityLog::log(
                        auth()->id(),
                        auth()->user()->username,
                        'auto_transfer_stock',
                        'Inventory',
                        'Auto-transferred from QUEUE to INVENTORY as ' . $nextBatchNumber . ': ' . $queuedStock->quantity . ' boxes of ' . $product->name,
                        'Success'
                    );
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'pieces_deducted' => $request->amount - $remainingPieces,
                'remaining_pieces' => $remainingPieces,
                'batches_used' => $batchesUsed,
                'auto_transferred' => isset($queuedStock) ? true : false,
                'message' => $remainingPieces > 0 
                    ? 'Insufficient stock. Only ' . ($request->amount - $remainingPieces) . ' pieces deducted.' 
                    : 'Stock deducted successfully using FIFO + Expiry Priority.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Deduct error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to deduct stock: ' . $e->getMessage()
            ], 500);
        }
    }

    public function transferStock($id)
    {
        try {
            DB::beginTransaction();
            
            $stockQueue = StockQueue::findOrFail($id);
            $productName = $stockQueue->product_name;
            
            $product = Product::where('name', $stockQueue->product_name)
                             ->where('brand', $stockQueue->brand ?? '')
                             ->where('dosage_amount', $stockQueue->dosage_amount)
                             ->where('dosage_unit', $stockQueue->dosage_unit)
                             ->first();
            
            if ($product) {
                $totalPiecesLeft = $product->batches()->where('pieces_left', '>', 0)->sum('pieces_left');
                
                if ($totalPiecesLeft > 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 
                        'Cannot transfer! Current stock has ' . number_format($totalPiecesLeft) . ' pieces remaining. ' .
                        'Please wait until stock runs out.'
                    );
                }
            }
            
            if (!$product) {
                $product = Product::create([
                    'name' => $stockQueue->product_name,
                    'barcode' => $stockQueue->barcode ?? Product::generateBarcode(),
                    'brand' => $stockQueue->brand,
                    'dosage_amount' => $stockQueue->dosage_amount,
                    'dosage_unit' => $stockQueue->dosage_unit,
                    'form' => $stockQueue->form,
                    'type' => $stockQueue->type,
                    'category' => $stockQueue->category,
                    'price' => $stockQueue->price
                ]);
                
                ActivityLog::log(
                    auth()->id(),
                    auth()->user()->username,
                    'add_medicine',
                    'Inventory',
                    'Created new product from queue: ' . $productName,
                    'Success'
                );
            }
            
            $totalPieces = $stockQueue->quantity * $stockQueue->pieces_per_box;
            
            ProductBatch::create([
                'product_id' => $product->id,
                'quantity' => $stockQueue->quantity,
                'pieces_per_box' => $stockQueue->pieces_per_box,
                'pieces_left' => $totalPieces,
                'total_pieces' => $totalPieces,
                'expiry_date' => $stockQueue->expiry_date,
                'arrival_date' => $stockQueue->arrival_date,
                'batch_number' => 'TRANSFER-' . time() . '-' . rand(100, 999)
            ]);
            
            $stockQueue->update([
                'status' => 'transferred',
                'transferred_at' => now(),
                'transferred_by' => auth()->id(),
            ]);
            
            $stockQueue->delete();
            
            DB::commit();

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'transfer_stock',
                'Inventory',
                'Manually transferred from QUEUE to INVENTORY: ' . $stockQueue->quantity . ' boxes of ' . $productName,
                'Success'
            );
            
            return redirect()->route('inventory.index', ['tab' => 'old-stock'])
                ->with('success', $productName . ' has been transferred to inventory!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transfer failed: ' . $e->getMessage());
        }
    }

    public function deleteStockQueue($id)
    {
        $queuedStock = StockQueue::findOrFail($id);
        $productName = $queuedStock->product_name;
        $queuedStock->delete();

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'delete_stock_queue',
            'Inventory',
            'Removed queued stock: ' . $productName,
            'Success'
        );

        return redirect()->route('inventory', ['tab' => 'new-stock'])
            ->with('success', 'Queued stock removed!');
    }

    public function updateBatch(Request $request, $batchId)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'pieces_per_box' => 'required|numeric|min:1',
            'expiry_date' => 'nullable|date',
            'arrival_date' => 'required|date',
        ]);
        
        try {
            DB::beginTransaction();
            
            $batch = ProductBatch::find($batchId);
            
            if (!$batch) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Batch not found!'
                ], 404);
            }
            
            $oldQuantity = $batch->quantity;
            $productName = $batch->product ? $batch->product->name : 'Unknown';
            $batchNumber = $batch->batch_number;
            
            $batch->quantity = $request->quantity;
            $batch->pieces_per_box = $request->pieces_per_box;
            $batch->expiry_date = $request->expiry_date;
            $batch->arrival_date = $request->arrival_date;
            
            $batch->save();
            
            DB::commit();

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'update_stock',
                'Inventory',
                'Updated batch ' . $batchNumber . ' for ' . $productName . ': ' . $oldQuantity . ' → ' . $request->quantity . ' boxes',
                'Success'
            );
            
            return response()->json([
                'status' => 'success',
                'message' => 'Batch updated successfully!',
                'batch' => $batch
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update batch: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getBatch($id)
    {
        try {
            $batch = ProductBatch::with('product')->findOrFail($id);
            
            return response()->json([
                'type' => 'batch',
                'batch' => $batch,
                'product' => $batch->product
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ============================================
    // ✅ GET PRODUCT FOR EDIT (AJAX)
    // ============================================
    public function getProductForEdit($id)
    {
        try {
            $product = Product::with('batches')->findOrFail($id);
            $batch = $product->batches->first();
            
            return response()->json([
                'status' => 'success',
                'product' => $product,
                'batch' => $batch
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}