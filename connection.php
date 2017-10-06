<?php
// 一度だけ読み込みます。
require_once('config.php');

// DB接続設定
function connectPdo() {
  try{
    return new PDO(DSN,DB_USER,DB_PASSWORD);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
}

  // 作成処理
  function insertDb($data) {
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (todo) VALUES (:todo)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':todo', $data, PDO::PARAM_STR);
    $stmt->execute();
  }

  // データ全件取得
  function selectAll() {
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
    $todo = array();
    foreach($dbh->query($sql) as $row) {
      array_push($todo, $row);
    }
    return $todo;
}

// 詳細取得
function getSelectData($id) {
  $dbh = connectPdo();
  $sql = 'SELECT todo FROM todos WHERE id = :id AND deleted_at IS NULL';
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':id' => (int)$id));
  $data = $stmt->fetch();
  return $data['todo'];
}


// 更新処理
function updateDb($id, $data) {
  $dbh = connectPdo();
  $sql = 'UPDATE todos SET todo = :todo WHERE id = :id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':todo', $data, PDO::PARAM_STR);
  $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
  $stmt->execute();
}

// 削除処理:論理削除
function deleteDb($id) {
  $dbh = connectPdo();
  $nowTime = date("Y-m-d H:i:s");
  $sql = 'UPDATE todos SET deleted_at = :deleted_at WHERE id = :id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':deleted_at', $nowTime);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
}
  ?>
