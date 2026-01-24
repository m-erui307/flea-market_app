<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品詳細</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
</head>
<body>
  <header class="header">
    <div class="header-inner">
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
          <li>
            <form class="logout-form" action="{{ route('logout') }}" method="post">
              @csrf
              <button type="submit" class="header-nav__item">ログアウト</button>
            </form>
          </li>
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
    </div>
  </header>
  <main>
    <div class="product__content">
      <div class="product-img">
        <img src="{{ $product->product_image }}" alt="商品画像">
      </div>
      <div class="product-detail__content">
        <div class="product-name">
          {{ $product->product_name }}
        </div>
        <div class="product-brand">
          {{ $product->brand }}
        </div>
        <div class="product-price">
          ¥{{ number_format($product->price) }}(税込)
        </div>
        <div class="like-comment__content">
          <div class="like-box">
            @auth
            @if($product->isLikedByAuthUser())
            {{-- いいね済み --}}
            <form action="{{ route('products.unlike', $product) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="like-btn">
                <img src="{{ asset('img/ハートロゴ_ピンク.png') }}" alt="いいね済み">
              </button>
            </form>
            @else
            {{-- 未いいね --}}
            <form action="{{ route('products.like', $product) }}" method="POST">
              @csrf
              <button type="submit" class="like-btn">
                <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="いいね">
              </button>
            </form>
            @endif
            @endauth

            @guest
            <a href="{{ route('login') }}" class="like-btn">
              <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="いいね">
            </a>
            @endguest
            <div class="count">
              {{ $product->likes_count }}
            </div>
          </div>
          <div class="comment-box">
            <img class="comment-btn" src="{{ asset('img/ふきだしロゴ.png') }}" alt="コメント">
            <div class="count">
              {{ $product->comments->count() }}
            </div>
          </div>
        </div>
        <a class="checkout" href="{{ Auth::check() ? route('purchase', $product) : route('login') }}">購入手続きへ</a>
        <div class="product-explanation">
          商品説明
        </div>
        <div class="explanation-content">
          {{ $product->explanation }}
        </div>
        <div class="product-info">
          商品の情報
        </div>
        <table class="product-info__table">
          <tr class="product-info__row">
            <th class="product-info__label">カテゴリー</th>
            <td class="product-info__data">
              @if($product->categories->isNotEmpty())
              @foreach($product->categories as $category)
              <span class="product-info__badge">{{ $category->name }}</span>
              @endforeach
              @else
                未設定
              @endif
            </td>
          </tr>
          <tr class="product-info__row">
            <th class="product-info__label">商品の状態</th>
            <td class="product-info__data--c">{{ $product->condition_label }}</td>
          </tr>
        </table>
        <div class="comment">
          コメント({{ $product->comments->count() }})
        </div>
        @foreach ($product->comments as $comment)
        <div class="user-content">
          <div class="user-img">
            @if ($comment->user->profile && $comment->user->profile->profile_image)
            <img src="{{ asset('storage/' . $comment->user->profile->profile_image) }}" alt="ユーザー画像">
          @endif
          </div>
          <div class="user-name">
            {{ $comment->user->user_name }}
          </div>
        </div>
        <div class="comment-content">
          {{ $comment->comment }}
        </div>
        @endforeach
        <div class="comment-field">
          商品へのコメント
        </div>
          <form method="POST" action="{{ route('comments.store', $product) }}" onsubmit="@guest event.preventDefault(); window.location='{{ route('login') }}'; @endguest">
          @csrf
          <textarea class="comment-field__item" name="comment" cols="25" rows="10">{{ old('comment') }}</textarea>
          <div class="form__error">
            @error('comment')
            {{ $message }}
            @enderror
          </div>
          <button class="post-btn">コメントを送信する</button>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>