<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $age = htmlspecialchars($_POST['age']);
    $prefecture = htmlspecialchars($_POST['prefecture']);

    $mail = new PHPMailer(true);

    try {
    
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = ' info@meiwa-industry.co.jp'; // Sender email 
        $mail->Password   = ''; // Apps code / App pass 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('info@meiwa-industry.co.jp', 'Web Recruitement'); // Sender email and name 
        $mail->addAddress('soumu@meiwa-industry.co.jp'); // Receiver email 
        $mail->addReplyTo($email, $name); 

        $mail->isHTML(false);
        $mail->CharSet = 'UTF-8'; 

        // Email Content
        $mail->Subject = "【新規応募】 " . $name . "様より";
        $mail->Body    = "新しい応募がありました。詳細は以下の通りです。\n";
        $mail->Body   .= "--------------------------------\n";
        $mail->Body   .= "お名前: " . $name . "\n";
        $mail->Body   .= "メールアドレス: " . $email . "\n";
        $mail->Body   .= "電話番号: " . $phone . "\n";
        $mail->Body   .= "年齢: " . $age . "\n";
        $mail->Body   .= "都道府県: " . $prefecture . "\n";
        $mail->Body   .= "--------------------------------\n";

        $mail->send();


        echo json_encode(['status' => 'success', 'message' => 'メールは正常に送信されました。']);
    } catch (Exception $e) {

        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => "メールの送信に失敗しました。エラー: {$mail->ErrorInfo}"]);
    }
} else {

    http_response_code(403);
    echo "Direct access not allowed.";
}
