@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">

        {{-- Single Unified Box --}}
        <div class="bg-white p-6 rounded-lg shadow space-y-8">

            {{-- Header inside the box --}}
            <h2 class="text-3xl font-bold text-gray-800">Edit Profile</h2>

            {{-- Avatar Upload --}}
            <div class="flex items-center space-x-4 mt-4 mb-4">
                <div class="flex-shrink-0">
                    <img class="h-16 w-16 rounded-full object-cover"
                         src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                         alt="{{ auth()->user()->name[0] }}">
                </div>
                <div>
                    <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatar-form">
                        @csrf
                        <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                        <label for="avatar" class="text-sm font-medium text-blue-600 hover:text-blue-500 cursor-pointer">
                            Change Avatar
                        </label>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </form>
                    <p class="text-sm text-gray-500 mt-1">JPG, PNG up to 5MB</p>
                </div>
            </div>

            {{-- Profile Information Form --}}
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <h3 class="text-lg font-medium text-gray-800 mb-4">Profile Information</h3>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Save Changes
                    </button>
                </div>
            </form>

            {{-- Password Update Form --}}
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <h3 class="text-lg font-medium text-gray-800 mb-4">Update Password</h3>

                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" id="current_password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
