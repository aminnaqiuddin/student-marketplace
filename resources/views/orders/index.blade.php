@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h1 class="text-2xl font-bold text-uitm-purple mb-6">My Orders</h1>

    @if($orders->isEmpty())
        <div class="text-gray-600">You have no orders yet.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 shadow-sm rounded-lg">
                <thead class="bg-uitm-purple text-white">
                    <tr>
                        <th class="p-3 text-left">Order ID</th>
                        <th class="p-3 text-left">Product</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-t">
                            <td class="p-3">{{ $order->id }}</td>
                            <td class="p-3">{{ $order->product->name ?? 'N/A' }}</td>
                            <td class="p-3">RM {{ number_format($order->price, 2) }}</td>
                            <td class="p-3">{{ ucfirst($order->status) }}</td>
                            <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
