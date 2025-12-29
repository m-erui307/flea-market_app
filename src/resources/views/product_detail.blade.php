<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
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
    <div class="product__content">
      <div class="product-img__content">
        <div class="product-img">
          <img src="{{ $product->product_image }}" alt="商品画像">
        </div>
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
            <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="いいね">
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
        <a class="checkout" href="{{ route('purchase', $product->id) }}">購入手続きへ</a>
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
            <td class="product-info__data"></td>
          </tr>
          <tr class="product-info__row">
            <th class="product-info__label">商品の状態</th>
            <td class="product-info__data">{{ $product->condition }}</td>
          </tr>
        </table>
        <div class="comment">
          コメント({{ $product->comments->count() }})
        </div>
        @foreach ($product->comments as $comment)
        <div class="user-content">
          <div class="user-img">
            <img src="{{ asset($comment->user->profile_image) }}">
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
        @auth
        <form method="POST" action="{{ route('comments.store', $product) }}">
          @csrf
          <textarea class="comment-field__item" name="comment" cols="25" rows="10"></textarea>
          <button class="post-btn">コメントを送信する</button>
        </form>
        @endauth
      </div>
    </div>
  </main>
</body>
</html>