<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
</head>
<body>
  <header class="header">
    <img class="header-logo" src="../../../img/COACHTECHヘッダーロゴ.png" alt="COACHTECH">
  </header>
  <main>
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar-title">
          その他の取引
        </div>
        @if($isSeller)
          @foreach($otherProducts as $otherProduct)
          <div class="side__product-name">
            <a href="{{ route('transaction.show', $otherProduct->id) }}">
              {{ $otherProduct->product_name }}
            </a>
          </div>
          @endforeach
        @endif
      </aside>
      <div class="content">
        <div class="title__content">
          <div class="title__profile-picture">
            @if($partnerProfile && $partnerProfile->profile_image)
            <img src="{{ asset('storage/' . $partnerProfile->profile_image) }}">
            @endif
          </div>
          <div class="title">
            「{{ $partner->user_name }}」さんとの取引画面
          </div>
          @if($isBuyer && !$purchase->completed_at)
          <form action="{{ route('transaction.complete', $product->id) }}" method="post">
            @csrf
            <button type="submit" class="complete-button">
              取引を完了する
            </button>
          </form>
          @endif
        </div>
        <div class="product__content">
          <div class="product-image">
            <img src="{{ $product->product_image }}" alt="商品画像">
          </div>
          <div class="product-detail">
            <div class="product-name">
              {{ $product->product_name }}
            </div>
            <div class="price">
              ¥{{ number_format($product->price) }}
            </div>
          </div>
        </div>
        <div class="message__content">
          @foreach($product->messages as $msg)
          @if($msg->user_id !== $user->id)
          <div class="customer__content">
            <div class="customer-detail">
              <div class="customer__profile-picture">
                @if($partnerProfile && $partnerProfile->profile_image)
                <img src="{{ asset('storage/' . $partnerProfile->profile_image) }}">
                @endif
              </div>
              <div class="customer__user-name">
                {{ $partner->user_name }}
              </div>
            </div>
            <div class="customer-message">
              <span class="message-text">{{ $msg->body }}</span>
              @if($msg->image)
              <div class="customer-message__img">
                <img src="{{ asset('storage/' . $msg->image) }}">
              </div>
              @endif
            </div>
          </div>
          @endif
          @if($msg->user_id === $user->id)
          <div class="vendor__content">
            <div class="vendor-detail">
              <div class="vendor__user-name">
                {{ $user->user_name }}
              </div>
              <div class="vendor__profile-picture">
                @if($myProfile && $myProfile->profile_image)
                  <img src="{{ asset('storage/' . $myProfile->profile_image) }}">
                @endif
              </div>
            </div>
            <div class="vendor-message">
              <span class="message-text">{{ $msg->body }}</span>
              <form action="{{ route('transaction.message.update', $msg->id) }}" method="post" class="edit-form" style="display: none;">
                @csrf
                @method('PATCH')
                <input type="text" name="body" value="{{ $msg->body }}" class="edit-input">
              </form>
              @if($msg->image)
              <div class="vendor-message__img">
                <img src="{{ asset('storage/' . $msg->image) }}">
              </div>
              @endif
            </div>
            <div class="button__content">
              <button class="edit-button">編集</button>
              <form action="{{ route('transaction.message.destroy', $msg->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="delete-button">削除</button>
              </form>
            </div>
          </div>
          @endif
          @endforeach
          <div class="send__content">
            <form action="{{ route('transaction.message.store', $product->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @if ($errors->any())
              <div class="error-message">
                @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
              </div>
              @endif
              <div class="input-row">
                <input class="message-input" type="text" name="body" placeholder="取引メッセージを記入してください">
                <label class="picture-select">画像を追加
                  <input class="picture-input" type="file" name="image" hidden>
                </label>
                <button type="submit" class="send-button">
                  <img src="{{ asset('img/inputbutton.png') }}">
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>
    document.querySelectorAll('.edit-button').forEach((btn) => {
      btn.addEventListener('click', function () {
      const parent = btn.closest('.vendor__content');

      const text = parent.querySelector('.message-text');
      const form = parent.querySelector('.edit-form');
      const input = parent.querySelector('.edit-input');

      text.style.display = 'none';
      form.style.display = 'block';

      input.focus();
      });
    });

    document.querySelectorAll('.edit-input').forEach((input) => {
      input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          this.closest('form').submit();
        }
      });
    });

    const messageInput = document.querySelector('.message-input');
    const sendForm = document.querySelector('.send__content form');

    if (messageInput && sendForm) {

      const storageKey = "message_" + {{ $product->id }};

      window.addEventListener('DOMContentLoaded', () => {
        const saved = localStorage.getItem(storageKey);
        if (saved) {
          messageInput.value = saved;
        }
      });

      messageInput.addEventListener('input', () => {
        if (messageInput.value.trim() === '') {
          localStorage.removeItem(storageKey);
        } else {
          localStorage.setItem(storageKey, messageInput.value);
        }
      });

      sendForm.addEventListener('submit', () => {
        localStorage.removeItem(storageKey);
      });
    }
    </script>
  </main>
  @if($purchase->completed_at && !$alreadyRated)
  <div id="modal" class="modal">
    <form action="{{ route('transaction.rating.store', $product->id) }}" method="post">
      @csrf
      <div class="complete-message">
        取引が完了しました。
      </div>
      <div class="evaluation-content">
        <div class="evaluation-message">
          今回の取引相手はどうでしたか？
        </div>
        <div class="evaluation-star">
          <input type="radio" name="rating" id="star5" value="5">
          <label for="star5">★</label>
          <input type="radio" name="rating" id="star4" value="4">
          <label for="star4">★</label>
          <input type="radio" name="rating" id="star3" value="3">
          <label for="star3">★</label>
          <input type="radio" name="rating" id="star2" value="2">
          <label for="star2">★</label>
          <input type="radio" name="rating" id="star1" value="1">
          <label for="star1">★</label>
        </div>
      </div>
      <div class="send-evaluation">
        <button type="submit" class="send-evaluation__button">
          送信する
        </button>
      </div>
    </form>
  </div>
  @endif
  @if($purchase->completed_at && !$alreadyRated)
  <script>
    window.location.hash = 'modal';
  </script>
  @endif
</body>
</html>


