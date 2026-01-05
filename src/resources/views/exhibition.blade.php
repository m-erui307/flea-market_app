<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
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
    <div class="exhibition-form__content">
      <div class="exhibition-form__heading">
        <h2>商品の出品</h2>
      </div>
      <form class="form">
        <div class="product-img">
          商品画像
        </div>
        <div class="img-content">
          <img id="preview-image" src="" alt="" style="display: none;">
        <label class="picture-select">画像を選択する
          <input type="file" name="image"
      class="picture-select__item"
      accept="image/*"
      onchange="previewImage(event)"
      hidden
    >
        </label>
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
<div class="product-condition">
  商品の状態
</div>
<select class="condition">
  <option disabled selected>選択してください</option>
  <option value="1">良好</option>
            <option value="2">目立った傷や汚れなし</option>
            <option value="3">やや傷や汚れあり</option>
            <option value="4">状態が悪い</option>
</select>
<div class="product-name-explanation">
  商品名と説明
</div>
<div class="product-name">
  商品名
</div>
<div class="brand">
  ブランド名
</div>
<div class="product-explanation">
  商品の説明
</div>
<div class="price">
  販売価格
</div>
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