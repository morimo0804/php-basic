<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false){
  print'ログインされていません。<br/>';
  print'<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
  exit();
 } else{
   print$_SESSION['staff_name'];
   print'さんログイン中';
   print'<br/>';
 }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ろくまる農園</title>
  <link rel="stylesheet" href="../css/global.css">
</head>
<body>

<?php
try{
    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='root';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT code,name FROM mst_staff WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    print'<h1>スタッフ一覧</h1><br/>';

    print'<form method="post" action="staff_branch.php">';
    print'<div class="container">';
    while(true){
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rec==false){
            break;
        }
        print'<input type="radio" name="staffcode" value="'.$rec['code'].'">';
        print $rec['name'];
        print'<br/>';
    }
    print'</div>';
    print'<input type="submit" name="disp" value="参照">';
    print'<input type="submit" name="add" value="追加">';
    print'<input type="submit" name="edit" value="修正">';
    print'<input type="submit" name="delete" value="削除">';
    print'</form>';
}
catch(Exception $e){
    print'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}
?>

<br/>
<a class="btn" href="../staff_login/staff_top.php">トップメニューへ</a><br/>
</body>
</html>