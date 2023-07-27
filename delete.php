<?php
//ログイン確認
session_start();
include("functions.php");
check_session_id();

// データ受け取り
$id = $_GET["id"];
// DB実行
$pdo = connect_to_db();
// SQL実行
$sql = "DELETE FROM users_table WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}


//////////////SQL実行処理////////////////////////////
header("Location:read.php");
exit();

?>