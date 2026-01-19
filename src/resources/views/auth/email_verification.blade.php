<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/email_verification.css') }}">
</head>
<body>
  <header class="header">
    <img class="header-logo" src="../../../img/COACHTECHヘッダーロゴ.png" alt="COACHTECH">
  </header>
  <main>
    <div class="verification-content">
      <div class="verification-message">
        登録していただいたメールアドレスに認証メールを送付しました。<br />メール認証を完了してください。
      </div>
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
      <button class="verification-btn" type="submit">
        認証はこちらから
      </button>
      <a class="verification-resend" href="">
        認証メールを再送する
      </a>
      </form>
  </main>
</body>
</html>