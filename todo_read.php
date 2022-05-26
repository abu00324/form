<?php

// DB接続
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


// SQL作成&実行
$sql = 'SELECT * FROM todo_table';


$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
  $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
  // echo '<pre>';
  // var_dump($result);
  // echo '</pre>';
  // exit();

$output = "";
foreach ($result as $record) {
$output .= "
<tr>
       <td>{$record["campany"]}</td>
       <td>{$record["kind"]}</td>
       <td>{$record["number"]}</td>
       <td>{$record["person"]}</td>
       <td>{$record["mail"]}</td>
       <td>{$record["phone"]}</td>
       <td>{$record["kown"]}</td>
       <td>{$record["time"]}</td>
       <td>{$record["comment"]}</td>
     </tr>
   ";
 }


} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}



?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>資料ダウンロード一覧</title>
</head>

<body>
  <fieldset>
    <legend>資料ダウンロード一覧</legend>
    <a href="todo_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
          <?=$output?>
      </tbody>
    </table>
  </fieldset>
  <script>
    const data = <?= json_encode($result)?>;
    console.log(data);
  </script>
</body>

</html>