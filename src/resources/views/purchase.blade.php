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
    <div class="content">
      <div class="detail-content">
        <div class="product-detail">
          <div class="product-img">
            <img src="{{ $product->product_image }}" alt="商品画像">
          </div>
          <div class="product-info">
          <div class="product-name">
            {{ $product->product_name }}
          </div>
          <div class="product-price">
          ¥{{ number_format($product->price) }}
          </div>
          </div>
        </div>
        <form action="{{ route('products.checkout', $product) }}" method="post">
    @csrf
        <div class="payment-content">
          <div class="payment-method">
            支払い方法
          </div>
          <select id="paymentSelect" name="payment" class="payment">
            <option value="" hidden selected>選択してください</option>
            <option value="1">コンビニ払い</option>
            <option value="2">カード払い</option>
          </select>
          <div class="form__error">
            @error('payment')
            {{ $message }}
            @enderror
            </div>
        </div>
        <div class="address-content">
          <div class="address-header">
          <div class="delivery-address">
            配送先
          </div>
          <div class="edit">
            <a class="edit-btn" href="{{ route('purchase.address.edit', $product) }}">変更する</a>
          </div>
</div>
          @if ($profile)
          <div class="postal-code">
            〒{{ $profile->postal_code }}
            <input type="hidden" name="postal_code" value="{{ $profile->postal_code }}">
          </div>
          <div class="address">
            {{ $profile->address }}{{ $profile->building }}
            <input type="hidden" name="address" value="{{ $profile->address }}">
            <input type="hidden" name="building" value="{{ $profile->building }}">
          </div>
          @else
          <div class="postal-code">
            〒XXX-YYYY
          </div>
          <div class="address">
            ここには住所と建物が入ります
          </div>
          @endif
          <div class="form__error">
            @error('delivery-address')
            {{ $message }}
            @enderror
            </div>
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
              <td id="paymentDisplay" class="confirm__data"></td>
            </tr>
          </table>
          <script>
    const paymentSelect = document.getElementById('paymentSelect');
    const paymentDisplay = document.getElementById('paymentDisplay');

    paymentSelect.addEventListener('change', function() {
        const selectedText = paymentSelect.options[paymentSelect.selectedIndex].text;
        paymentDisplay.textContent = selectedText;
    });
</script>
          <button class="purchase-btn">購入する</button>
  </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>