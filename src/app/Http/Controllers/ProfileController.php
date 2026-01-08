<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $profile = $user->profile;

        return view('profile_settings', compact('user', 'profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;
        $profile->postal_code = $request->postal_code;
        $profile->address = $request->address;
        $profile->building = $request->building;

        // プロフィール画像
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')
                ->store('profiles', 'public');

            $profile->profile_image = $path;
        }

        $profile->save();

        $user->update([
            'user_name' => $request->user_name,
        ]);

        return redirect()->route('product.list');
    }

    public function index()
    {
        $user = Auth::user();

    $products = Product::where('user_id', $user->id)->get();
    $profile = $user->profile;

    return view('profile', compact('user', 'products', 'profile'));
    }

}