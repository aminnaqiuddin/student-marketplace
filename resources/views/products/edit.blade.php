@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">

    <div class="bg-white border rounded-lg shadow p-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Edit Product</h2>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                {{-- Title --}}
                <div class="col-span-1">
                    <label class="block font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Price --}}
                <div class="col-span-1">
                    <label class="block font-medium text-gray-700 mb-1">Price (RM)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Category --}}
                <div class="col-span-1">
                    <label class="block font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Condition --}}
                <div class="col-span-1">
                    <label class="block font-medium text-gray-700 mb-1">Condition</label>
                    <select name="condition" id="condition" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Select Condition --</option>
                        @foreach($conditions as $cond)
                            <option value="{{ $cond }}" {{ $product->condition == $cond ? 'selected' : '' }}>
                                {{ ucfirst($cond) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Condition Rating --}}
                <div class="md:col-span-2" id="condition-rating-container" style="display: none;">
                    <label class="block font-medium text-gray-700 mb-1">Condition Rating</label>
                    <select name="condition_rating" class="w-full border rounded px-3 py-2">
                        <option value="">-- Select Condition Rating --</option>
                        @foreach (['Like New', 'Very Good', 'Good', 'Fair', 'Heavily Used'] as $rating)
                            <option value="{{ $rating }}" {{ $product->condition_rating == $rating ? 'selected' : '' }}>
                                {{ $rating }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Quantity --}}
                <div class="col-span-1" id="quantity-container">
                    <label class="block font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1"
                           value="{{ old('quantity', $product->quantity) }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                {{-- Description --}}
                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border rounded px-3 py-2 resize-y">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Upload New Images --}}
                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 mb-1">Add New Image(s)</label>
                    <input type="file" name="images[]" multiple class="w-full border rounded px-3 py-2">
                    <small class="text-gray-500">You can upload new images; existing ones remain unless replaced in backend logic.</small>
                </div>

                {{-- Existing Images --}}
                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 mb-2">Current Images</label>
                    @if ($product->images->isNotEmpty())
                        <div class="flex flex-wrap gap-4">
                            @foreach ($product->images as $image)
                                <div class="w-32 h-32 border rounded overflow-hidden shadow-sm">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        alt="Product Image"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No images available.</p>
                    @endif
                </div>
            </div>

            <div class="text-right mt-6">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const conditionSelect = document.getElementById('condition');
        const ratingContainer = document.getElementById('condition-rating-container');
        const categorySelect = document.getElementById('category_id');
        const quantityContainer = document.getElementById('quantity-container');
        const quantityInput = document.getElementById('quantity');

        const serviceCategoryNames = ['services'];

        function toggleConditionRating() {
            ratingContainer.style.display = conditionSelect.value.toLowerCase() === 'used' ? 'block' : 'none';
        }

        function toggleQuantityField() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const categoryName = selectedOption.textContent.trim().toLowerCase();
            const isService = serviceCategoryNames.includes(categoryName);

            if (isService) {
                quantityContainer.style.display = 'none';
                quantityInput.value = '';
            } else {
                quantityContainer.style.display = 'block';
            }
        }

        conditionSelect.addEventListener('change', toggleConditionRating);
        categorySelect.addEventListener('change', toggleQuantityField);

        // Initial run on page load
        toggleConditionRating();
        toggleQuantityField();
    });
</script>
@endpush
