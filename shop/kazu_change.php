<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ろくまる農園</title>
    <link rel="stylesheet" href="../css/global.css" />
  </head>
  <body>
    <?php
session_start();
session_regenerate_id(true);

require_once('../common/common.php');

$post=sanitize($_POST);

$max=$post['max'];
for($i=0;$i<$max;$i++){
  if(preg_match("/\A[0-9]+\z/",$post['kazu'.$i])==0){
    print'数量に誤りがあります。';
    print'<a href="shop_cartlook.php">カートに戻る</a>';
    exit();
  }
  if($post['kazu'.$i]<1 || 10<$post['kazu'.$i]){
    print'数量は必ず1個以上、10個までです。';
    print'<br/>';
    print'<br/>';
    print'<a class="btn" href="shop_cartlook.php">カートに戻る</a>';
     exit();
  }
  $kazu[]=$post['kazu'.$i];
}

$cart=$_SESSION['cart'];

for($i=$max;0<=$i;$i--){
  if(isset($_POST['sakujo'.$i])==true){
    array_splice($cart,$i,1);
    array_splice($kazu,$i,1);
  }
}

$_SESSION['cart']=$cart;
$_SESSION['kazu']=$kazu;

header('Location:shop_cartlook.php');
exit();
?>

  </body>
</html>
