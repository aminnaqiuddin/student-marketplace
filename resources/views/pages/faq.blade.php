@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h1 class="text-4xl font-bold text-uitm-purple mb-10 ">Frequently Asked Questions</h1>

    <div class="space-y-8 divide-y divide-gray-200">
        <!-- Question 1 -->
        <div class="pt-4">
            <h2 class="text-xl font-semibold text-gray-800">🛍️ How do I list a product?</h2>
            <p class="text-gray-700 mt-2">
                You can list a product by clicking the <strong>“Sell Item”</strong> button in the top navigation bar.
                Complete the form by entering product name, description, category, price, quantity, and upload clear images.
                Once submitted, your listing will be published immediately and visible to all users.
            </p>
        </div>

        <!-- Question 2 -->
        <div class="pt-4">
            <h2 class="text-xl font-semibold text-gray-800">✏️ Can I edit or remove my product after it's listed?</h2>
            <p class="text-gray-700 mt-2">
                Yes! Navigate to the <strong>“My Products”</strong> section in your profile.
                From there, you can edit your product details, change availability status, or delete the listing entirely.
            </p>
        </div>

        <!-- Question 3 -->
        <div class="pt-4">
            <h2 class="text-xl font-semibold text-gray-800">💬 How do I contact a seller?</h2>
            <p class="text-gray-700 mt-2">
                On any product page, click the <strong>“Message Seller”</strong> button.
                This will open the chat window where you can directly communicate with the seller.
                Please be polite and respectful when initiating conversations.
            </p>
        </div>

        <!-- Question 4 -->
        <div class="pt-4">
            <h2 class="text-xl font-semibold text-gray-800">💵 Is there a fee for selling on UniMarketplace?</h2>
            <p class="text-gray-700 mt-2">
                No. UniTrade is a free platform for students to buy and sell within the campus community.
                We do not charge listing fees, transaction fees, or commissions.
            </p>
        </div>

        <!-- Question 5 -->
        <div class="pt-4">
            <h2 class="text-xl font-semibold text-gray-800">📦 What happens after someone buys my product?</h2>
            <p class="text-gray-700 mt-2">
                You will receive an order notification and a chat will be opened between you and the buyer.
                Arrange for delivery or meet-up, and make sure to mark the product as sold once completed.
            </p>
        </div>

        <!-- Question 6 -->
        <div class="pt-4">
            <h2 class="text-xl font-semibold text-gray-800">🔐 Is my data secure?</h2>
            <p class="text-gray-700 mt-2">
                Yes, we value your privacy. All user information is securely stored and not shared with third parties.
                We use secure authentication and encryption practices.
            </p>
        </div>
    </div>
</div>
@endsection
