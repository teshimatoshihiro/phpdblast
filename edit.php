<?php

//ログイン確認
session_start();
include("functions.php");
check_session_id();

$id = $_GET["id"];

// ///////////////////////////////
$pdo = connect_to_db();
//SELECT 文を用いて id 指定し
$sql = 'SELECT * FROM users_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
// バインド変数を設定//////////////////////////////////////////
// ハッキング防止のため、ユーザー入力値をSQL内で使用する際にはbind変数を使用する
////////////////////////////////////////////////////////////////
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}
//fetch() 関数でデータを取得する
$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <title>（編集画面）</title>
</head>

<body>

<form action="update.php" method="POST">
  <fieldset>
    <legend>（編集画面）</legend>
    <a href="read.php">一覧画面</a>
    <div>
      名前: <input type="text" name="username" value="<?= $record['username'] ?>">
    </div>
<!-- /////////////////////////////////// -->
<!-- <div>
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
</div> -->
<!-- ////////////////////////////////// -->

    <div>
      職種: <input type="text" name="occupation" value="<?= $record['occupation'] ?>">
    </div>
    <div>
      専門: <input type="text" name="department" value="<?= $record['department'] ?>">
    </div>
    <div>
      居住地域: <input type="text" name="residential" value="<?= $record['residential'] ?>">
    </div>
    <div>
      email: <input type="text" name="email" value="<?= $record['email'] ?>">
    </div>
    <div>
      password: <input type="text" name="password="value="<?= $record['password'] ?>">
    </div>
    <div>
      is_admin: <input type="text" name="is_admin="value="<?= $record['is_admin'] ?>">
    </div>
    <div>
      created_at: <input type="date" name="created_at" value="<?= $record['created_at'] ?>">
    </div>
    <div>
      updated_at: <input type="date" name="updated_at" value="<?= $record['updated_at'] ?>">
    </div>
    <div>
      deleted_at: <input type="date" name="deleted_at" value="<?= $record['deleted_at'] ?>">
    </div>

<!-- 次の更新処理で id が必要になるため，<input type="hidden"> を用いて id を送信する． -->
    <div>
      <input type="hidden" name="id" value="<?= $record['id'] ?>">
    </div>
    <div>
      <button>submit</button>
    </div>
  </fieldset>
</form>

</body>

</html>