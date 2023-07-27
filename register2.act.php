<?php
include('functions.php');

// var_dump($_POST);
// exit();


if (
 

  // /////////////////////////////////////////////////////////
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

  exit('paramError');
}

// //////////////////////////////////////
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
// /////////////////////////////////////
$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM users_table WHERE username=:username';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  echo '<p>すでに登録されているユーザです．</p>';
  echo '<a href="login.php">login</a>';
  exit();
}

$sql = 'INSERT INTO users_table (id, username, occupation, department, residential, email, password, is_admin, created_at, updated_at, deleted_at)
        VALUES (NULL, :username, :occupation, :department, :residential, :email, :password, :is_admin, now(), now(), NULL)';


// ・自己流改修・・・・・・・・・・・・・・・
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':occupation',$occupation, PDO::PARAM_STR); // 空の値を追加
$stmt->bindValue(':department',$department, PDO::PARAM_STR); // 空の値を追加
$stmt->bindValue(':residential',$residential, PDO::PARAM_STR); // 空の値を追加
$stmt->bindValue(':email',$email, PDO::PARAM_STR); // 空の値を追加
$stmt->bindValue(':is_admin', 0, PDO::PARAM_INT); // デフォルト値を追加

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location: login.php");
exit();

?>