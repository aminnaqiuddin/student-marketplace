@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-4xl font-bold text-uitm-purple mb-8 ">About UniTrade</h2>

    <div class="space-y-8 text-gray-700 leading-relaxed text-lg">
        <p>
            <strong>UniMarketplace</strong> is a student-powered platform designed to simplify buying and selling within campus communities.
            Whether you're looking to sell used textbooks, score affordable electronics, or offer services like tutoring or printing —
            this is your one-stop campus marketplace.
        </p>

        <p>
            Created with student needs at the core, UniMarketplace focuses on affordability, trust, and convenience. We aim to foster a
            safe community where students can exchange goods and services while promoting sustainability and reducing waste.
        </p>

        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Why Choose UniMarketplace?</h2>
            <ul class="list-disc list-inside space-y-2">
                <li>👩‍🎓 Built by students, for students</li>
                <li>🔒 Safe and verified university user base</li>
                <li>📦 Buy & sell anything from books to gadgets to services</li>
                <li>💬 Seamless communication via in-platform messaging</li>
            </ul>
        </div>

        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Mission</h2>
            <p>
                To build a sustainable and student-driven campus economy through peer-to-peer commerce — driven by transparency,
                community trust, and user convenience.
            </p>
        </div>

        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact Us</h2>
            <p>
                Got questions or feedback? We’d love to hear from you! Email us at
                <a href="mailto:support@unimarketplace.test" class="text-uitm-purple underline hover:text-uitm-purple-dark">
                    support@unitrade.test
                </a>.
            </p>
        </div>
    </div>
</div>
@endsection
