<?php
//ログイン確認
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();

// SQL作成&実行//////////////////////////////////////////
//全てのカラムを参照/////////////////////////////////////
$sql = 'SELECT * FROM users_table ORDER BY updated_at ASC';
$stmt = $pdo->prepare($sql);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL実行の処理///////////////////////////////////////////
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  $output .= "
    <tr>
      <td>{$record["username"]}</td>
      <td>{$record["occupation"]}</td>
      <td>{$record["department"]}</td>
      <td>{$record["residential"]}</td>
      <td>{$record["email"]}</td>
      <td>{$record["password"]}</td>
      <td>{$record["is_admin"]}</td>
      <td>{$record["created_at"]}</td>
      <td>{$record["updated_at"]}</td>
      <td>{$record["deleted_at"]}</td>
  
  <td>
  <a href='edit.php?id={$record["id"]}'>edit</a>
  </td>
      <td>
        <a href='delete.php?id={$record["id"]}'>delete</a>
        </td>
    </tr>
  ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="read.css">
  <title>データベース（一覧）</title>
</head>

<body>
  <fieldset>
    <legend>データベース一覧<?=$_SESSION['username']?>さん</legend>
    
    <a href="register.php">(入力画面へ)</a>
    <a href="furiwake.php">(選択画面に戻る)</a>
    
    
    <table>
      <thead>
        <tr>
          <th>名前</th>
          <th>職種</th>
          <th>専門</th>
          <th>居住地域</th>
          <th>email</th>
          <th>パスワード</th>
          <th>is_admin</th>
          <th>created_at</th>
          <th>updated_at</th>
          <th>deleted_at</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>


</html>