<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ろくまる農園</title>
    <link rel="stylesheet" href="../css/global.css">
    <style>
      .info-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-width: 600px;
        margin: 20px auto;
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background: #f9f9f9;
      }

      .info-item {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #ddd;
        padding-bottom: 6px;
      }

      .label {
        font-weight: bold;
        color: #333;
      }

      .value {
        width: 60%;
        color: #444;
        text-align: right;
      }
    </style>
  </head>
  <body>
   <?php

    require_once('../common/common.php');

    $post = sanitize($_POST);

    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];
    $chumon = $post['chumon'];
    $pass = isset($post['pass']) ? $post['pass'] : '';
    $pass2 = isset($post['pass2']) ? $post['pass2'] : '';
    $danjo = isset($post['danjo']) ? $post['danjo'] : '';
    $birth = isset($post['birth']) ? $post['birth'] : '';
    $okflg = true;

    if ($onamae == '') {
      print 'お名前が入力されていません。<br/><br/>';
      $okflg = false;
    }

    if (preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/', $email) == 0) {
      print 'メールアドレスを正確に入力してください。<br/><br/>';
      $okflg = false;
    }

    if (preg_match('/\A[0-9]+\z/', $postal1) == 0 || preg_match('/\A[0-9]+\z/', $postal2) == 0) {
      print '郵便番号は半角数字で入力してください。<br/><br/>';
      $okflg = false;
    }

    if ($address == '') {
      print '住所が入力されていません。<br/><br/>';
      $okflg = false;
    }

    if (preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel) == 0) {
      print '電話番号を正確に入力してください。<br/><br/>';
      $okflg = false;
    }

    if ($chumon == 'chumontouroku') {
      if ($pass == '') {
        print 'パスワードが入力されていません。<br/><br/>';
        $okflg = false;
      }

      if ($pass != $pass2) {
        print 'パスワードが一致しません。<br/><br/>';
        $okflg = false;
      }
    }

    if ($okflg == true) {
      print '<div class="info-container">';
      print '<div class="info-item"><div class="label">お名前</div><div class="value">' . $onamae . '</div></div>';
      print '<div class="info-item"><div class="label">メールアドレス</div><div class="value">' . $email . '</div></div>';
      print '<div class="info-item"><div class="label">郵便番号</div><div class="value">' . $postal1 . '-' . $postal2 . '</div></div>';
      print '<div class="info-item"><div class="label">住所</div><div class="value">' . $address . '</div></div>';
      print '<div class="info-item"><div class="label">電話番号</div><div class="value">' . $tel . '</div></div>';

      if ($chumon == 'chumontouroku') {
        print '<div class="info-item"><div class="label">性別</div><div class="value">' . ($danjo == 'dan' ? '男性' : '女性') . '</div></div>';
        print '<div class="info-item"><div class="label">生まれ年</div><div class="value">' . $birth . '年代</div></div>';
      }

      print '</div>';

      print '<form method="post" action="shop_form_done.php">';
      print '<input type="hidden" name="onamae" value="' . $onamae . '">';
      print '<input type="hidden" name="email" value="' . $email . '">';
      print '<input type="hidden" name="postal1" value="' . $postal1 . '">';
      print '<input type="hidden" name="postal2" value="' . $postal2 . '">';
      print '<input type="hidden" name="address" value="' . $address . '">';
      print '<input type="hidden" name="tel" value="' . $tel . '">';
      print '<input type="hidden" name="chumon" value="' . $chumon . '">';
      print '<input type="hidden" name="pass" value="' . $pass . '">';
      print '<input type="hidden" name="danjo" value="' . $danjo . '">';
      print '<input type="hidden" name="birth" value="' . $birth . '">';
      print '<div class="buttons">';
      print '<input type="button" onclick="history.back()" value="戻る">';
      print '<input type="submit" value="OK">';
      print '</div>';
      print '</form>';
    } else {
      print '<form>';
      print '<input type="button" onclick="history.back()" value="戻る">';
      print '</form>';
    }

    ?>
  </body>
</html>
