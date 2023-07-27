<?php
//ログイン確認
session_start();
include("functions.php");
check_session_id();
// / 入力項目のチェック
// ****************************************************
// 格納するデータが送信されていない、また空の時に警告を出す
// *************************************************

if (
  !isset($_POST['id'])         || $_POST['id'] === '' ||
  !isset($_POST['username'])   || $_POST['username'] === '' ||
  !isset($_POST['occupation']) || $_POST['occupation'] === ''||
  !isset($_POST['department']) || $_POST['department'] === ''||
  !isset($_POST['regidential'])|| $_POST['regidential'] === ''||
  !isset($_POST['email'])      || $_POST['email'] === ''||
  !isset($_POST['password'])   || $_POST['password'] === ''||
  !isset($_POST['is_admin'])   || $_POST['is_admin'] === ''||
  !isset($_POST['created_at']) || $_POST['created_at'] === ''||
  !isset($_POST['updated_at']) || $_POST['updated_at'] === ''||
  !isset($_POST['deleted_at']) || $_POST['deleted_at'] === ''
) {
  exit('paramError');
}
// *****************************************
// データの受け取り
// 変数宣言
// ********************************************
$id          = $_POST['id'];
$username    = $_POST['username'];
$occupation  = $_POST['occupation'];
$department  = $_POST['department'];
$residential = $_POST['residential'];
$email       = $_POST['email'];
$password    = $_POST['password'];
$is_admin    = $_POST['is_admin'];
$created_at  = $_POST['created_at'];
$updated_at  = $_POST['updated_at'];
$deleted_at  = $_POST['deleted_at'];

// DB接続
$pdo = connect_to_db();
// SQL作成&実行////////////////////////////////////
//$sql変数のテーブル、カラム名、値をupdate
// 必ず WHERE で id を指定すること！！！
//////////////////////////////////////////////////////
$sql = 'UPDATE users_table SET name=:username, occupation=:occupation,department=:department,residential=:regidential,email=:email,password=:password,is_admin=:is_admin,created_at=:created_at,updated_at=:updated_at,deleted_at=:deleted_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);

// バインド変数を設定//////////////////////////////////////////
// ハッキング防止のため、ユーザー入力値をSQL内で使用する際にはbind変数を使用する
////////////////////////////////////////////////////////////////
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->bindValue(':username'   , $username, PDO::PARAM_STR);
$stmt->bindValue(':occupation' , $occupation, PDO::PARAM_STR);
$stmt->bindValue(':department' , $department, PDO::PARAM_STR);
$stmt->bindValue(':residential', $residential, PDO::PARAM_STR);
$stmt->bindValue(':password'   , $password, PDO::PARAM_STR);
$stmt->bindValue(':is_admin'   , $is_admin, PDO::PARAM_STR);
$stmt->bindValue(':created_at' , $created_at, PDO::PARAM_STR);
$stmt->bindValue(':updated_at' , $updated_at, PDO::PARAM_STR);
$stmt->bindValue(':deleted_at' , $deleted_at, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//////////////SQL実行処理////////////////////////////
header('Location:read.php');
exit();
