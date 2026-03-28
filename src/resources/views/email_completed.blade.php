<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <p>{{ $product->user->user_name }}様</p>
    <p>商品「{{ $product->product_name }}」の購入者が取引を完了しました。</p>
    <p>取引相手: {{ $purchase->user->user_name }}</p>
    <p>取引を確認してください。</p>
</body>
</html>