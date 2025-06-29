@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Report Product</h2>

    <p class="text-gray-600 mb-6">
        If you believe this listing violates our terms, is a scam, or includes inappropriate content, please submit a report below. We will review it promptly.
    </p>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('report.product') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Report</label>
                <textarea name="reason" id="reason" rows="4" required
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                          placeholder="Explain briefly why you're reporting this product..."></textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ url()->previous() }}"
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 mr-2">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
