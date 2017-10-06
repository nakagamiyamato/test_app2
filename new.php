<?php
require_once('functions.php');
setToken(); //  追記
?>
<!DOCTYPE html>
<html lang='ja'>
  <head>
    <meta charset="utf-8">
    <title>新規作成</title>
  </head>
  <body>
    <?php if(isset($_SESSION['err'])): ?>
  <p><?php echo $_SESSION['err'] ?></p>
<?php endif; ?>
    <form action="store.php" method="post">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']);?>">
      <input type="text" name="todo">
      <input type="submit" value="作成">
    </form>
    <div>
      <a href="index.php">一覧へ戻る</a>
    </div>
    <?php unsetSession(); ?>
  </body>
</html>
