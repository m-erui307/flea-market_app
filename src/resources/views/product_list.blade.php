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
    <form class="search-form" action="{{ url()->current() }}" method="get">
    @csrf
    <div class="search-form__item">
      <input class="search-form__item-input" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
    </div>
    </form>
    <nav class="header-nav">
      <ul class="header-nav__list">
        @if (Auth::check())
        <form class="form" action="{{ route('logout') }}" method="post">
          @csrf
          <li><button type="submit" class="header-nav__item">ログアウト</button></li>
        </form>
        @else
      <li>
        <a href="{{ route('login') }}" class="header-nav__item">
          ログイン
        </a>
      </li>
        @endif
        <li><a class="header-nav__item" href="{{ Auth::check() ? route('profile.index') : route('login') }}">マイページ</a></li>
        <li><a class="header-nav__item-l" href="{{ Auth::check() ? route('exhibition') : route('login') }}">出品</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="product-list__nav">
      <a href="{{ route('product.list', ['keyword' => request('keyword')]) }}" class="product-list__nav--recs {{ $type === 'recommend' ? 'active' : '' }}">
    おすすめ
  </a>
      <a href="{{ route('products.recommend', ['keyword' => request('keyword')]) }}" class="product-list__nav--my-list {{ $type === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>
    <div class="product-list">
      @if($type === 'recommend')
      @foreach($products as $product)
      <div class="product-list__content">
        <a href="{{ route('products.show', $product->id) }}">
          <div class="product-list__img">
            <img src="{{ $product->product_image }}" alt="商品画像">
            @if($product->purchase)
        <div class="sold-label">sold</div>
      @endif
          </div>
        </a>
        <div class="product-name">
          {{ $product->product_name }}
        </div>
      </div>
      @endforeach
      @endif

      @if($type === 'mylist' && Auth::check())
    @foreach($products as $product)
      <div class="product-list__content">
        <a href="{{ route('products.show', $product->id) }}">
          <div class="product-list__img">
            <img src="{{ $product->product_image }}" alt="商品画像">
            @if($product->purchase)
              <div class="sold-label">sold</div>
            @endif
          </div>
        </a>
        <div class="product-name">
          {{ $product->product_name }}
        </div>
      </div>
    @endforeach
  @endif
    </div>
  </main>
</body>
</html>