@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h1 class="text-2xl font-bold mb-4">Notifications</h1>

    @if($notifications->count())
        <form method="POST" action="{{ route('notifications.markAsRead') }}">
            @csrf
            <button type="submit" class="mb-4 bg-uitm-purple text-white px-4 py-2 rounded hover:bg-uitm-gold">
                Mark all as read
            </button>
        </form>

        <ul class="space-y-4">
            @foreach($notifications as $notification)
                <li class="p-4 rounded shadow {{ $notification->read_at ? 'bg-gray-100' : 'bg-yellow-50' }}">
                    {{ $notification->data['message'] ?? 'You have a new notification.' }}
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-600">You have no notifications.</p>
    @endif
</div>
@endsection
