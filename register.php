<?php
  require_once("db_config.php");

  //取得表單資料
  $account = $_POST["account"];
  $password = $_POST["password"];
  $name = $_POST["name"];
  $sex = $_POST["sex"];
  $cellphone = $_POST["cellphone"];
  $email = $_POST["email"];
  $comment = $_POST["comment"];

  //檢查帳號是否有人申請
  $sql = "SELECT COUNT(*) FROM members2 WHERE account = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$account]);
  $exists = (int) $stmt->fetchColumn();

  //如果帳號已經有人使用
  if ($exists !== 0)
  {
    //顯示訊息要求使用者更換帳號名稱 -- 直接產生網頁的程式碼！
    echo "<script type='text/javascript'>";
    echo "alert('您所指定的帳號已經有人使用，請使用其它帳號');";
    echo "history.back();";
    echo "</script>";
  }

  //如果帳號沒人使用
  else
  {
    //執行 SQL 命令，新增此帳號
    $sql = "INSERT INTO members2 (account, password, name, sex, cellphone, email, comment)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$account, $password, $name, $sex, $cellphone, $email, $comment]);
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新增帳號成功</title>
  </head>
  <body bgcolor="#FFFFFF">
    <p align="center"><img src="Success.jpg">
    <p align="center">恭喜您已經註冊成功了，您的資料如下：（請勿按重新整理鈕）<br>
      帳號：<font color="#FF0000"><?php echo $account ?></font><br>
      密碼：<font color="#FF0000"><?php echo $password ?></font><br>
      請記下您的帳號及密碼，然後<a href="login.html">登入網站</a>。
    </p>
  </body>
</html>