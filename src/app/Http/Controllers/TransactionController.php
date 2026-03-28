<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionCompleted;

class TransactionController extends Controller
{
    public function complete($productId)
    {
        $purchase = Purchase::where('product_id', $productId)
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        // まだ完了していなければ完了日時を更新
        if (!$purchase->completed_at) {
            $purchase->completed_at = now();
            $purchase->save();

            // 出品者に通知メール送信
            $product = $purchase->product; // PurchaseからProduct取得
            Mail::to($product->user->email)->send(new TransactionCompleted($product, $purchase));
        }

        // 元の挙動通り取引ページにリダイレクト
        return redirect()->route('transaction.show', $productId);
    }
}
