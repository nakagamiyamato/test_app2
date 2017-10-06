<?php
  require('functions.php');
  unsetSession();
?>
<!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta  charset="ja">
    <title>Home</title>
  </head>
  <body>
    Welcome hello world
    <div>
      <a href="new.php">
        <p>新規作成</p>
      </a>
    </div>
    <div>
      <table>
        <tr>
          <th>ID</th>
          <th>内容</th>
          <th>更新</th>
          <th>削除</th>
        </tr>
      <?php foreach(index() as $todo): ?>
         <tr>
           <td><?php echo h($todo['id']) ?></td>
           <td><?php echo h($todo['todo']) ?></td>
           <td>
             <a href="edit.php?id=<?php echo h($todo['id']) ?>">更新</a>
           </td>
           <td>
             <form action="store.php" method="POST">
               <input type="hidden" name="id" value="<?php echo h($todo['id']) ?>">
               <input type="hidden" name="type" value="delete">
               <button type="submit">削除</button>
             </form>
           </td>
         </tr>
   <?php endforeach; ?>
      </table>
    </div>
  </body>
</html>
