<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    public function store(MessageRequest $request, Product $product)
    {
        $request->validate([
            'body' => 'required|string|max:400',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $imagePath = null;

        // 画像がある場合保存
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages', 'public');
        }

        // メッセージ保存
        Message::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'body' => $request->body,
            'image' => $imagePath,
        ]);

        return back(); // ←これでOK
    }


    public function update(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);

        // 自分のメッセージだけ編集可
        if ($message->user_id !== Auth::id()) {
            abort(403);
        }

        $message->body = $request->body;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('messages', 'public');
            $message->image = $path;
        }

        $message->save();

        return back();
    }

    public function destroy($messageId)
    {
        $message = Message::findOrFail($messageId);

        if ($message->user_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return back();
    }
}
