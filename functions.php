<?php
require('connection.php');
session_start();

// エスケープ処理
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

// sessionに暗号化したtokenを入れる
function setToken() {
  $token = sha1(uniqid(mt_rand(),true));
  $_SESSION['token'] = $token;
}

// sessionのチェックを行いcsrf対策を行う
function checkToken($data) {
  if (empty($_SESSION['token']) || ($_SESSION['token'] != $data)){
    $_SESSION['err'] = '不正な操作です';
    header('location: '.$_SERVER['HTTP_REFERER'].'');
    exit();
  }
  return true;
}
function unsetSession() {
  if(!empty($_SESSION['err'])) $_SESSION['err'] = '';
}

function create($data) {
  if(checkToken($data['token'])){ //追記
      insertDb($data['todo']);
  }
}


// 全件取得
function index() {
  return $todos = selectAll();
}

// 更新
function update($data) {
  if(checkToken($data['token'])){
  updateDb($data['id'], $data['todo']);
  }
}

// 詳細の取得
function detail($id) {
  return getSelectData($id);
}



function checkReferer() {
  $httpArr = parse_url($_SERVER['HTTP_REFERER']);
  return $res = transition($httpArr['path']);
}

function transition($path) {
  unsetSession();
  $data = $_POST;
  if(isset($data['todo'])) $res = validate($data['todo']);
  if($path === '/index.php' && $data['type'] === 'delete'){
    deleteData($data['id']);
    return 'index';
  }elseif(!$res || !empty($_SESSION['err'])){ // 追記
    return 'back';  // 追記
  }elseif($path === '/new.php'){
    create($data);
  }elseif($path === '/edit.php'){
    update($data);
  }
}
function validate($data) {
  return $res = $data != "" ? true : $_SESSION['err'] = '入力がありません';
}


function deleteData($id) {
  deleteDb($id);
}


?>
