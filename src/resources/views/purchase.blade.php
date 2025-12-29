<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
</head>
<body>
  <header class="header">
    <img class="header-logo" src="../../../img/COACHTECHヘッダーロゴ.png">
    <form class="search-form" action="/search" method="get">
    @csrf
    <div class="search-form__item">
      <input class="search-form__item-input" type="text" name="keyword" value="{{ old('keyword') }}" placeholder="なにをお探しですか？">
    </div>
    </form>
    <nav class="header-nav">
      <ul class="header-nav__list">
        <li><a class="header-nav__item" href="/login">ログアウト</a></li>
        <li><a class="header-nav__item" href="">マイページ</a></li>
        <li><a class="header-nav__item-l" href="">出品</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="content">
      <div class="detail-content">
        <div class="product-detail">
          <div class="product-img">
            <img src="{{ $product->product_image }}" alt="商品画像">
          </div>
          <div class="product-name">
            {{ $product->product_name }}
          </div>
          <div class="product-price">
          ¥{{ number_format($product->price) }}
          </div>
        </div>
        <div class="payment-content">
          <div class="payment-method">
            支払い方法
          </div>
          <select class="payment">
            <option value="1">コンビニ払い</option>
            <option value="2">カード払い</option>
          </select>
        </div>
          <div class="delivery-address">
            配送先
          </div>
          @if ($profile)
          <div class="postal-code">
            〒{{ $profile->postal_code }}
          </div>
          <div class="address">
            {{ $profile->address }}{{ $profile->building }}
          </div>
          @else
          <p>住所が登録されていません</p>
          <a href="/profile_settings">住所を登録する</a>
          @endif
        </div>
      </div>
      <div class="confirm-content">
        <table class="confirm__table">
          <tr class="confirm__row">
            <th class="confirm__label">商品代金</th>
            <td class="confirm__data">¥{{ number_format($product->price) }}</td>
          </tr>
          <tr class="confirm__row">
            <th class="confirm__label">支払い方法</th>
            <td class="confirm__data"></td>
          </tr>
        </table>
        <button class="purchase-btn">購入する</button>
      </div>

  </main>
</body>
</html>