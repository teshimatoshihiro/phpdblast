<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
    
  <title>ログイン画面</title>

</head>

<!-- ログイン情報(username,password)を入力して送信する -->
<body>

  <!-- <form action="login_act.php" method="POST"> -->
  <form action="login2_act.php" method="POST">
    <fieldset>
      <legend>ログイン画面</legend>
      <div>
        名前: <input type="text" name="username">
      </div>
      <div>
        パスワード: <input type="text"name="password" >
      </div>
      <div>
        <button>ログイン</button>
      </div>
      <a href="register.php">or 新規登録</a>
    </fieldset>
  </form>

</body>

</html>