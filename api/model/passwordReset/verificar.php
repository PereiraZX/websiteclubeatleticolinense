<?php
include_once '../../connection/conn.php';

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_adm = $_POST['user_adm'];

    // Verifica se o usuário existe no banco de dados
    $sql_check_user = "SELECT id_adm, email_adm FROM adm WHERE user_adm = :user_adm";
    $stmt_check_user = $pdo->prepare($sql_check_user);
    $stmt_check_user->bindParam(':user_adm', $user_adm);
    $stmt_check_user->execute();

    if ($stmt_check_user->rowCount() > 0) {
        $user_data = $stmt_check_user->fetch(PDO::FETCH_ASSOC);
        $email_adm = $user_data['email_adm'];

        // Gerar um token único
        $token = uniqid();
    
        // Definir a data de expiração do token (5 minutos a partir do momento atual)
        $expiryDate = date('Y-m-d H:i:s', strtotime('+5 minutes'));
    
        // Atualizar o token e a data de expiração no banco de dados para o usuário encontrado
        $sql_update_token = "UPDATE adm SET token = :token, expiry_date = :expiry_date WHERE id_adm = :id_adm";
        $stmt_update_token = $pdo->prepare($sql_update_token);
        $stmt_update_token->bindParam(':token', $token);
        $stmt_update_token->bindParam(':expiry_date', $expiryDate);
        $stmt_update_token->bindParam(':id_adm', $user_data['id_adm']);
        $stmt_update_token->execute();
    
        // Criar uma instância do PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'seu_email@gmail.com';
        $mail->Password = 'sua_senha';
    
        // Configurações do remetente e destinatário
        $mail->setFrom('seu_email@gmail.com', 'Seu Nome');
        $mail->addAddress($email_adm);
    
        // Configurações do e-mail
        $mail->Subject = 'Redefinição de senha';
        $mail->Body = "Olá! Clique no link a seguir para redefinir sua senha: reset.php?token=$token";
    
        // Envio do e-mail
        if ($mail->send()) {
            echo "Um e-mail com as instruções para redefinir sua senha foi enviado para o seu endereço de e-mail cadastrado.";
        } else {
            echo "Falha ao enviar o e-mail: " . $mail->ErrorInfo;
        }
    } else {
        echo "Usuário não existe ou está incorreto!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Esqueceu a Senha</title>
</head>
<body>
    <h2>Esqueceu a Senha</h2>
    <form method="POST" action="">
        <label for="user_adm">Usuário:</label>
        <input type="text" name="user_adm" required>
        <br>
        <button type="submit">Enviar Link de Recuperação</button>
    </form>
</body>
</html>
