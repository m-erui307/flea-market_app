<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>出品</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
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
          <a href="{{ route('login') }}" class="header-nav__item">ログイン</a>
        </li>
        @endif
        <li>
          <a class="header-nav__item" href="{{ Auth::check() ? route('profile.index') : route('login') }}">マイページ</a>
        </li>
        <li>
          <a class="header-nav__item-l" href="{{ Auth::check() ? route('exhibition') : route('login') }}">出品</a>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="exhibition-form__content">
      <div class="exhibition-form__heading">
        <h2>商品の出品</h2>
      </div>
      <form class="exhibition-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="product-img">
          商品画像
        </div>
        <div class="img-content">
          <img id="preview-image" src="" alt="" style="display: none;">
          <label class="picture-select">画像を選択する
          <input type="file" name="product_image" class="picture-select__item" accept="image/*" onchange="previewImage(event)" hidden>
          </label>
        </div>
        <div class="form__error">
          @error('product_image')
          {{ $message }}
          @enderror
        </div>
        <div class="product-detail">
          商品の詳細
        </div>
        <div class="category">
          カテゴリー
        </div>
        <div class="category-list">
          @foreach($categories as $category)
          <input type="checkbox" name="category_ids[]" id="category{{ $category->id }}" value="{{ $category->id }}" class="category-checkbox">
          <label for="category{{ $category->id }}" class="category-label">
            {{ $category->name }}
          </label>
          @endforeach
        </div>
        <div class="form__error">
          @error('category_ids')
          {{ $message }}
          @enderror
        </div>
        <div class="product-condition">
          商品の状態
        </div>
        <select class="condition" name="condition">
          <option value="" hidden selected>選択してください</option>
          <option value="1">良好</option>
          <option value="2">目立った傷や汚れなし</option>
          <option value="3">やや傷や汚れあり</option>
          <option value="4">状態が悪い</option>
        </select>
        <div class="form__error">
          @error('condition')
          {{ $message }}
          @enderror
        </div>
        <div class="product-name-explanation">
          商品名と説明
        </div>
        <div class="product-name">
          商品名
        </div>
        <div class="product-name__input">
          <input type="text" name="product_name">
        </div>
        <div class="form__error">
          @error('product_name')
          {{ $message }}
          @enderror
        </div>
        <div class="brand">
          ブランド名
        </div>
        <div class="brand__input">
          <input type="text" name="brand">
        </div>
        <div class="product-explanation">
          商品の説明
        </div>
        <div class="product-explanation__input">
          <input type="text" name="explanation">
        </div>
        <div class="form__error">
          @error('explanation')
          {{ $message }}
          @enderror
        </div>
        <div class="price">
          販売価格
        </div>
        <div class="price__input">
          <span class="yen">¥</span>
          <input type="text" name="price">
        </div>
        <div class="form__error">
          @error('price')
          {{ $message }}
          @enderror
        </div>
        <div class="form__button">
          <button class="form__button-submit" type="submit">出品する</button>
        </div>
      </form>
      <script>
        function previewImage(event) {
          const file = event.target.files[0];
          const preview = document.getElementById('preview-image');

          if (!file) {
          preview.style.display = 'none';
          preview.src = '';
          return;
          }

          const reader = new FileReader();
          reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
          };
          reader.readAsDataURL(file);
        }
      </script>
    </div>
  </main>
</body>
</html>