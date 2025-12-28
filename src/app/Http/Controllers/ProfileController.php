<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $profile = $user->profile ?? Profile::create([
            'user_id' => $user->id,
        ]);

        return view('profile_settings', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        // プロフィール画像
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')
                ->store('profiles', 'public');

            $profile->profile_image = $path;
        }

        // users テーブル更新
        $user->update([
            'user_name' => $request->user_name,
        ]);

        // profiles テーブル更新
        $profile->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect('/product_list');
    }
}