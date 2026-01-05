<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/address_change.css') }}">
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
    <div class="address-change-form__content">
        <div class="address-change-form__heading">
        <h2>住所の変更</h2>
      </div>
      <form class="form" action="{{ route('purchase.address.update', $product) }}" method="post">
        @csrf
    <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">郵便番号</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="postal_code" value="{{ old('postal_code', $user->profile->postal_code ?? '') }}" />
            </div>
            <div class="form__error">
            @error('postal_code')
            {{ $message }}
            @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">住所</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="address" value="{{ old('address', $user->profile->address ?? '') }}" />
            </div>
            <div class="form__error">
            @error('address')
            {{ $message }}
            @enderror
            </div>
          </div>
        </div>
        <div class="form__group">
          <div class="form__group-title">
            <span class="form__label--item">建物名</span>
          </div>
          <div class="form__group-content">
            <div class="form__input--text">
              <input type="text" name="building" value="{{ old('building', $user->profile->building ?? '') }}" />
            </div>
          </div>
        </div>
        <div class="form__button">
          <button class="form__button-submit" type="submit">更新する</button>
        </div>
      </form>
    </div>