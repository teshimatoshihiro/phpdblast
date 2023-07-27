<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <title>新規登録画面</title>
</head>

<!-- <body>
  <form action="register_act.php" method="POST">
    <fieldset>
      <legend>新規登録画面</legend>
      <div>
        ユーザー名: <input type="text" name="username">
      </div>
      <div>
        パスワード: <input type="text" name="password">
      </div>
      <div>
        <button>登録</button>
      </div> -->


  <!-- 今入れてみた -->
<form action="register2.act.php" method="POST">
    <fieldset>
      <legend>新規登録（入力画面）</legend>
      <!-- <a href="read.php">新規登録</a> -->
      <div>
        名前: <input type="text" name="username">
      </div>
<div>
  職種<input type="text"list="occupation"  name="occupation">
    <datalist id="occupation" >

      <option value=""></option>
      <option value="超音波専門医"></option>
      <option value="超音波検査士"></option>
      <option value="医師"></option>
      <option value="臨床検査技師（超音波検査士非所持）"></option>
      <option value="放射線技師（超音波検査士非所o持）"></option>
      <option value="看護師"></option>
  </datalist>
</div>

  <div>
  専門<input type="text" list="department" name="department">
  <datalist id="department">

      <option value=""></option>
      <option value="心臓"></option>
      <option value="腹部"></option>
      <option value="血管"></option>
      <option value="体表"></option>
      <option value="検診"></option>
      <option value="乳腺以外なんでも"></option>
      <option value="心臓以外なんでも"></option>
      <option value="腹部以外なんでも"></option>
      <option value="なんでもできる"></option>
  </datalist>
</div>

  <div>
  居住地域<input type="text" list="residential" name="residential">
  <datalist id="residential">

  <option value=""></option>
  <option value="北海道"></option>
  <option value="東北"></option>
  <option value="北陸"></option>
  <option value="中部"></option>
  <option value="関東"></option>
  <option value="関西"></option>
  <option value="中国"></option>
  <option value="四国"></option>
  <option value="九州"></option>
</datalist>
</div>

      <div>
        email: <input type="text" name="email">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        管理（一般は0を入力）: <input type="text" name="is_admin">
      </div>
      <div>
        作成日: <input type="date" name="created_at">
      </div>
      <div>
        updated_at: <input type="date" name="updated_at">
      </div>
      <div>
        deleted_at: <input type="date" name="deleted_at">
      </div>
      <div>
        <button>登録</button>
      </div>
    </fieldset>
  </form>
  <!-- ここまで -->
      <a href="login.php">or ログインへ</a>
    </fieldset>
  </form>

</body>

</html>