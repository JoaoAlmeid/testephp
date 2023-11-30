<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

$email_destinatario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_destinatario = $_POST['email']; // Captura o email do formulario
    $token = bin2hex(random_bytes(32));

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'mail.acrie.com.br';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'joao.miguel@acrie.com.br';
        $mail->Password   = '={Jm56727121}';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Configurações do e-mail
        $mail->setFrom('joao.miguel@acrie.com.br', 'João Miguel');
            $mail->addAddress($email_destinatario);  // Usa o e-mail do formulário como destinatário
            $mail->Subject = 'Recuperação de Senha';
            $mail->Body    = "Você solicitou a recuperação de senha. Clique no link abaixo para redefinir sua senha:\n\n";
            $mail->Body   .= "http://localhost/php/teste-php/redefinir_senha.php?token=$token\n\n";
            $mail->Body   .= "Se você não solicitou essa recuperação, ignore este e-mail.";

            $mail->send();
        echo 'E-mail enviado com sucesso';
    } catch (Exception $e) {
        echo 'Erro no envio do e-mail: ', $mail->ErrorInfo;
    }
}
?>