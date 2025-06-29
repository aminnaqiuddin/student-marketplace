@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-4xl font-bold text-uitm-purple mb-6">Privacy Policy</h2>

    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
        At UniTrade, we value your privacy and are committed to protecting your personal data. This Privacy Policy outlines how we collect, use, store, and safeguard your information when you use our platform.
    </p>

    <!-- Section 1 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">1. Information We Collect</h2>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Your name, email address, and student ID (for verification)</li>
        <li>Profile details including avatar, bio, and join date</li>
        <li>Product listings, transaction history, and chat activity</li>
        <li>Technical data like IP address, browser type, and device info</li>
    </ul>

    <!-- Section 2 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">2. How We Use Your Information</h2>
    <p class="text-gray-700 mb-4">
        Your information is used to:
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Create and manage your account</li>
        <li>Enable communication between buyers and sellers</li>
        <li>Display your listings, reviews, and public profile</li>
        <li>Improve user experience and troubleshoot issues</li>
        <li>Ensure security and prevent misuse of the platform</li>
    </ul>

    <!-- Section 3 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">3. Data Security</h2>
    <p class="text-gray-700 mb-4">
        We implement appropriate security measures to protect your data, including HTTPS encryption, role-based access, and secure server hosting. However, no system is 100% secure and we cannot guarantee absolute protection.
    </p>

    <!-- Section 4 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">4. Data Sharing</h2>
    <p class="text-gray-700 mb-4">
        We do <strong>not</strong> sell your personal data. We may only share it:
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>With third-party services like payment gateways (e.g., for transactions)</li>
        <li>When required by law, regulation, or university policy</li>
        <li>To investigate and respond to misuse or security incidents</li>
    </ul>

    <!-- Section 5 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">5. Your Rights</h2>
    <p class="text-gray-700 mb-4">
        You have the right to:
    </p>
    <ul class="list-disc list-inside text-gray-700 mb-4">
        <li>Access and update your profile information</li>
        <li>Request deletion of your account and data</li>
        <li>Contact support for privacy-related inquiries</li>
    </ul>

    <!-- Section 6 -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-2">6. Cookies</h2>
    <p class="text-gray-700 mb-4">
        We use cookies to remember your preferences and enhance user experience. You may disable cookies in your browser settings, but this may affect certain site features.
    </p>

    <!-- Last updated -->
    <p class="text-sm text-gray-500 mt-12">Last updated: {{ now()->format('F Y') }}</p>
</div>
@endsection
