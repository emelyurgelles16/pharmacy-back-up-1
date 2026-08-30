@extends('layouts.app')

@section('title', 'New Stock Queue')

@section('content')
<style>
    .header-box {
        background: #056b28;
        color: #fff;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
    }

    th {
        background: #1b5e20;
        color: white;
        font-weight: 600;
    }

    .btn-transfer {
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-remove {
        background: #dc3545;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div class="header-box">
    <h2>📦 New Stock Queue</h2>
    <p>Stock waiting for current inventory to run out</p>
</div>

@if($queuedStocks->isEmpty())
<div style="text-align: center; padding: 40px;">
    <h3>No stock in queue</h3>
    <p>All new stock has been transferred to inventory.</p>
</div>
@else
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Brand</th>
            <th>Quantity</th>
            <th>Arrival Date</th>
            <th>Added By</th>
            <th>Current Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($queuedStocks as $stock)
        @php
            $currentProduct = $stock->product;
            $currentStock = $currentProduct ? $currentProduct->quantity : 0;
        @endphp
        <tr>
            <td>{{ $stock->product_name ?? $stock->product->name }}</td>
            <td>{{ $stock->brand ?? $stock->product->brand }}</td>
            <td>{{ $stock->quantity }} boxes</td>
            <td>{{ \Carbon\Carbon::parse($stock->arrival_date)->format('M d, Y') }}</td>
            <td>{{ $stock->addedByUser->username }}</td>
            <td>
                @if($currentProduct)
                    {{ $currentStock }} boxes
                    @if($currentStock <= 0)
                        <span style="color: red;">(Empty!)</span>
                    @endif
                @else
                    <span style="color: orange;">New Product</span>
                @endif
            </td>
            <td>
                <form action="{{ route('stock-queue.transfer', $stock->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-transfer">Transfer Now</button>
                </form>
                <form action="{{ route('stock-queue.destroy', $stock->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-remove">Remove</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection