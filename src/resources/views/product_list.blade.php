<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product_list.css') }}">
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
        @if (Auth::check())
        <form class="form" action="{{ route('logout') }}" method="post">
          @csrf
          <li><button type="submit" class="header-nav__item">ログアウト</button></li>
        </form>
        @endif
        <li><a class="header-nav__item" href="">マイページ</a></li>
        <li><a class="header-nav__item-l" href="">出品</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="product-list__nav">
      <button class="product-list__nav--recs">おすすめ</button>
      <button class="product-list__nav--my-list">マイリスト</button>
    </div>
    <div class="product-list">
      @foreach($products as $product)
      <div class="product-list__content">
        <a href="{{ route('products.show', $product->id) }}">
          <div class="product-list__img">
            <img src="{{ $product->product_image }}" alt="商品画像">
          </div>
        </a>
        <div class="product-name">
          {{ $product->product_name }}
        </div>
      </div>
      @endforeach
    </div>
  </main>
</body>
</html>