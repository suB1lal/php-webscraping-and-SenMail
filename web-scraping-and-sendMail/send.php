<?php
require_once('guzzle_requests.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'vendor/autoload.php';

    // Verileri dosyadan al
    $data = json_decode(file_get_contents('veriler.json'), true);
    $mail = new PHPMailer();

    $mail->IsSMTP();

    $mail->SMTPKeepAlive = true;
    $mail->SMTPAuth  = true;
    $mail->SMTPSecure = 'tls';

    $mail->Port = '587'; //def olarak 25
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'test123@gmail.com';//mail adresinizi yazın
    $mail->Password = "google-app-secu";//google mail üzerinden uygulama güvenliği için verdiği kodu girin

    $mail->setFrom(address: "gönderici mail adresi", name: "isimgirmeniz yeterli");
    $mail->addAddress(address: "alıcımailadresi@gmail.com", name: "name");
    $mail->isHTML(true);
    $mail->Subject = "Gmail Deneme";
    $mail->Body = "<h1>Merhaba  işte kitap fiyatları </h1>";
    foreach ($data as $item) {
        $mail->Body .= "<p>{$item['title']} @ {$item['price']}</p>";
    }
    //Dosya Göndermek istiyorsak bu parametreyi kulllanmalıyız
    //$mail->addAttachment(path: "dosya.txt", name: "Bilgiler!");

    if ($mail->send()) {
        echo "Gönderim Başarılı";
    } else {
        echo "Sorun oluştu";
        echo $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    }



    ?>
</body>

</html>