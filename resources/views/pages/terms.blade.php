@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-4xl font-bold text-uitm-purple mb-6">Terms & Conditions</h2>

    <p class="text-gray-700 text-lg leading-relaxed mb-6">
        These Terms & Conditions govern your use of UniTrade. By accessing or using the platform, you agree to comply with the following terms. Please review them carefully.
    </p>

    <!-- Section 1 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">1. Eligibility</h2>
    <p class="text-gray-700 mb-4">
        Only verified students from participating universities are eligible to:
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Create an account on UniMarketplace</li>
        <li>List products or services</li>
        <li>Engage in buying or selling activities</li>
    </ul>

    <!-- Section 2 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">2. Listings</h2>
    <p class="text-gray-700 mb-4">
        Users are fully responsible for the content and accuracy of their listings. Prohibited items include (but are not limited to):
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Illegal goods or substances</li>
        <li>Stolen or counterfeit items</li>
        <li>Offensive, harmful, or misleading content</li>
    </ul>

    <!-- Section 3 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">3. Transactions</h2>
    <p class="text-gray-700 mb-4">
        UniMarketplace is a student-to-student platform. We are not responsible for:
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Quality or condition of items sold</li>
        <li>Payment disputes</li>
        <li>Delivery, returns, or refunds</li>
    </ul>
    <p class="text-gray-700 mb-4">
        Use your judgment when making purchases. Transactions are at your own risk.
    </p>

    <!-- Section 4 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">4. User Conduct</h2>
    <p class="text-gray-700 mb-4">
        Users must engage respectfully and ethically. Prohibited behaviors include:
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Harassment or abusive messages</li>
        <li>Scams, fraud, or misrepresentation</li>
        <li>Spamming or repeated unsolicited messages</li>
    </ul>
    <p class="text-gray-700">
        Violations may result in account suspension or removal.
    </p>

    <!-- Footer -->
    <p class="text-sm text-gray-500 mt-12">Last updated: {{ now()->format('F Y') }}</p>
</div>
@endsection
