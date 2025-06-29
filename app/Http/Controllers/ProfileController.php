<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $averageRating = Review::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->avg('rating');

        return view('profile.index', [
            'user' => $user,
            'orders' => $user->orders()->paginate(5),
            'products' => $user->products()->paginate(5),
            'averageRating' => $averageRating,
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => [
                'required',
                File::image()
                    ->max(5120) // 5MB
                    ->dimensions(
                        Rule::dimensions()
                            ->maxWidth(2000)
                            ->maxHeight(2000)
                    ),
            ],
        ]);

        if ($request->user()->avatar) {
            Storage::disk('public')->delete($request->user()->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $relativePath = str_replace('public/', '', $path);

        $request->user()->update(['avatar' => $relativePath]);

        return back()->with('status', 'avatar-updated')
                     ->with('message', 'Avatar updated successfully!');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($request->user()->id)
            ],
        ]);

        $request->user()->fill($request->only(['name', 'email']));

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return back()->with('status', 'profile-updated')
                     ->with('message', 'Profile information updated successfully!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('status', 'password-updated')
                     ->with('message', 'Password updated successfully!');
    }

    public function show(User $user)
    {
        $averageRating = Review::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->avg('rating');

        $reviews = Review::with(['reviewer', 'product'])
            ->whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(5);

        return view('profile.show', [
            'user' => $user,
            'products' => $user->products()->active()->latest()->paginate(8),
            'averageRating' => $averageRating,
            'reviews' => $reviews
        ]);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
