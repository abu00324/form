<?php
// POSTデータ確認
// var_dump($_POST);
// exit();

if (
  !isset($_POST['company']) || $_POST['company']=='' ||
  !isset($_POST['person']) || $_POST['person']=='' ||
  !isset($_POST['mail']) || $_POST['mail']=='' ||
  !isset($_POST['phone']) || $_POST['phone']==''
) {
  exit('データがありません');
}

$company = $_POST['company'];
$kind = $_POST['kind'];
$number = $_POST['number'];
$person = $_POST['person'];
$mail = $_POST['mail'];
$phone = $_POST['phone'];
$kown = $_POST['kown'];
$time = $_POST['time'];
$comment = $_POST['comment'];


$dbn ='mysql:dbname=download;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}




// DB接続

// SQL作成&実行
$sql = 'INSERT INTO todo_table (id, company, kind, number, person, mail, phone, kown, time, comment, created_at, updated_at) VALUES (NULL, :company, kind, number, :person, :mail, :phone, kown, time, :comment, now(), now())';


$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':company', $company, PDO::PARAM_STR);
$stmt->bindValue(':person', $person, PDO::PARAM_STR);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);


// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL作成&実行

header('Location:todo_input.php');
exit();
