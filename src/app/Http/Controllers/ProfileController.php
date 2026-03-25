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

    public function index(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $tab = $request->query('tab', 'exhibition'); // デフォルト：出品

        // --- 商品取得 ---
        if ($tab === 'purchase') {
            $products = $user->purchases()
                ->with('product')
                ->get()
                ->pluck('product');

        } elseif ($tab === 'transaction') {
            // 自分が関わる取引中の商品を取得
            $purchasedProducts = $user->purchases()
                ->with('product')
                ->get()
                ->pluck('product')
                ->filter();

            $soldProducts = Product::where('user_id', $user->id)
                ->whereHas('purchase')
                ->get();

            $products = $purchasedProducts
                ->merge($soldProducts)
                ->unique('id')
                ->values();

            // --- 各商品の未読件数と最新メッセージ日時を取得 ---
            $products = $products->map(function ($product) use ($user) {
                $unreadCount = $product->messages()
                    ->where('user_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->count();

                $latestMessage = $product->messages()
                    ->latest('created_at')
                    ->first();

                $product->unread_label = $unreadCount === 0 ? null : ($unreadCount > 99 ? '99+' : $unreadCount);
                $product->latestMessageAt = $latestMessage->created_at ?? null;

                return $product;
            });

            // --- 並び替え：最新メッセージ順（新着順） ---
            $products = $products->sortByDesc('latestMessageAt')->values();

        } else { // 出品
            $products = Product::where('user_id', $user->id)->get();
        }

        // --- 取引中タブの合計未読バッジ ---
        $transactionProducts = $user->purchases()
            ->with('product')
            ->get()
            ->pluck('product')
            ->merge(
                Product::where('user_id', $user->id)
                    ->whereHas('purchase')
                    ->get()
            )
            ->unique('id')
            ->values();

        $totalUnread = $transactionProducts->sum(function ($product) use ($user) {
            return $product->messages()
                ->where('user_id', '!=', $user->id)
                ->whereNull('read_at')
                ->count();
        });

        $totalUnreadLabel = $totalUnread === 0 ? null : ($totalUnread > 99 ? '99+' : $totalUnread);

        return view('profile', compact(
            'user',
            'profile',
            'products',
            'tab',
            'totalUnreadLabel'
        ));
    }
}