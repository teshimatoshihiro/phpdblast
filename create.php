<?php
//ログイン確認
session_start();
include("functions.php");
check_session_id();

if (
  !isset($_POST['username'])   || $_POST['username'] === '' ||
  !isset($_POST['occupation']) || $_POST['occupation'] === ''||
  !isset($_POST['department']) || $_POST['department'] === ''||
  !isset($_POST['residential'])|| $_POST['residential'] === ''||
  !isset($_POST['email'])      || $_POST['email'] === ''||
  !isset($_POST['password'])   || $_POST['password'] === ''||
  !isset($_POST['is_admin'])   || $_POST['is_admin'] === ''||
  !isset($_POST['created_at']) || $_POST['created_at'] === ''||
  !isset($_POST['updated_at']) || $_POST['updated_at'] === ''||
  !isset($_POST['deleted_at']) || $_POST['deleted_at'] === ''

) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}
// *****************************************
// データの受け取り
// 変数宣言
// ********************************************
$username    = $_POST['username'];
$occupation  = $_POST['occupation'];
$department  = $_POST['department'];
$regidential = $_POST['residential'];
$email       = $_POST['email'];
$password    = $_POST['password'];
$is_admin    = $_POST['is_admin'];
$created_at  = $_POST['created_at'];
$updated_at  = $_POST['updated_at'];
$deleted_at  = $_POST['deleted_at'];
////////////////////////////

// DB接続
$pdo = connect_to_db();

// SQL作成&実行////////////////////////////////////
//$sql変数のテーブル、カラム名、値を書き換え
//////////////////////////////////////////////////////
$sql = 'INSERT INTO users_table (id,created_at,updated_at,username,occupation,department,residential,email,password,is_admin,created_at,updated_at,deleted_at) VALUES(NULL,now(), now(), 
:username,:occupation,:department,:residential,:password,:is_admin,:email,:deadline)';
//////////////////////////////////////////////////////////

$stmt = $pdo->prepare($sql);
// バインド変数を設定//////////////////////////////////////////
// ハッキング防止のため、ユーザー入力値をSQL内で使用する際にはbind変数を使用する
////////////////////////////////////////////////////////////////
$stmt->bindValue(':username'   , $username, PDO::PARAM_STR);
$stmt->bindValue(':occupation' , $occupation, PDO::PARAM_STR);
$stmt->bindValue(':department' , $department, PDO::PARAM_STR);
$stmt->bindValue(':residential', $residential, PDO::PARAM_STR);
$stmt->bindValue(':email'      , $email,      PDO::PARAM_STR);
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
header("Location:input.php");
exit();
