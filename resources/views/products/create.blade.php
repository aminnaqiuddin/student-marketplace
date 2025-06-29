@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-xl font-bold mb-4">Add Product</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- title -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Title</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- description -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" required></textarea>
            </div>

            <!-- price -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Price (RM)</label>
                <input type="number" step="0.01" name="price" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- category -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Category</label>
                <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- condition -->
            <div class="mb-4" id="condition-container">
                <label class="block mb-1 font-medium">Condition</label>
                <select name="condition" id="condition" class="w-full border rounded px-3 py-2">
                    <option value="">-- Select Condition --</option>
                    @foreach($conditions as $cond)
                        <option value="{{ $cond }}">{{ ucfirst($cond) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- condition rating -->
            <div class="mb-4" id="condition-rating-container" style="display: none;">
                <label class="block mb-1 font-medium">Condition Rating</label>
                <select name="condition_rating" class="w-full border rounded px-3 py-2">
                    <option value="">-- Select Condition Rating --</option>
                    <option value="Like New">Like New</option>
                    <option value="Very Good">Very Good</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                    <option value="Heavily Used">Heavily Used</option>
                </select>
            </div>

            <!-- quantity -->
            <div class="mb-4" id="quantity-container">
                <label class="block mb-1 font-medium">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="1" class="w-full border rounded px-3 py-2">
            </div>

            <!-- images -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Images</label>
                <input type="file" name="images[]" class="w-full border rounded px-3 py-2" multiple required>
                <small class="text-gray-500">Upload image(s).</small>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">Post Product</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const conditionSelect = document.getElementById('condition');
        const conditionContainer = document.getElementById('condition-container');
        const ratingContainer = document.getElementById('condition-rating-container');
        const categorySelect = document.getElementById('category_id');
        const quantityContainer = document.getElementById('quantity-container');
        const quantityInput = document.getElementById('quantity');

        const skipConditionCategories = ['services', 'food & beverages', 'event tickets'];

        function toggleConditionFields() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const categoryName = selectedOption.textContent.trim().toLowerCase();
            const shouldHide = skipConditionCategories.includes(categoryName);

            conditionContainer.style.display = shouldHide ? 'none' : 'block';
            ratingContainer.style.display = (!shouldHide && conditionSelect.value.toLowerCase() === 'used') ? 'block' : 'none';

            if (shouldHide) {
                conditionSelect.value = '';
            }
        }

        function toggleConditionRating() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const categoryName = selectedOption.textContent.trim().toLowerCase();
            const shouldHide = skipConditionCategories.includes(categoryName);

            if (!shouldHide && conditionSelect.value.toLowerCase() === 'used') {
                ratingContainer.style.display = 'block';
            } else {
                ratingContainer.style.display = 'none';
            }
        }

        function toggleQuantityField() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const categoryName = selectedOption.textContent.trim().toLowerCase();
            const isService = skipConditionCategories.includes(categoryName);

            quantityContainer.style.display = isService ? 'none' : 'block';
            if (isService) {
                quantityInput.value = '';
            }
        }

        conditionSelect.addEventListener('change', toggleConditionRating);
        categorySelect.addEventListener('change', function () {
            toggleConditionFields();
            toggleQuantityField();
        });

        toggleConditionFields();
        toggleConditionRating();
        toggleQuantityField();
    });
</script>
@endpush
@endsection
