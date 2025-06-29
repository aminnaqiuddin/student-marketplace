<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            My Products
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($products->isEmpty())
                <p class="text-gray-600">You haven't listed any products yet.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white p-4 rounded shadow">
                            <h3 class="text-lg font-semibold text-uitm-purple">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $product->description }}</p>
                            <p class="text-sm font-medium mt-2">RM {{ number_format($product->price, 2) }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="text-sm text-uitm-purple underline mt-2 inline-block">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
