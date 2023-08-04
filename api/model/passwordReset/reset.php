<?php
include_once '../../connection/conn.php';

require '../../../PHPMailer/PHPMailer.php';
require '../../../PHPMailer/SMTP.php';
require '../../../PHPMailer/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Verificar se o token está presente na URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar se o token está presente no banco de dados e ainda é válido
    $sql_check_token = "SELECT expiry_date, email_adm FROM adm WHERE token = :token";
    $stmt_check_token = $pdo->prepare($sql_check_token);
    $stmt_check_token->bindParam(':token', $token);
    $stmt_check_token->execute();

    if ($stmt_check_token->rowCount() > 0) {
        $result = $stmt_check_token->fetch(PDO::FETCH_ASSOC);
        $expiryDate = $result['expiry_date'];
        $email_adm = $result['email_adm'];

        // Comparar a data de expiração com a data atual
        if (strtotime($expiryDate) >= time()) {
            // O token ainda está válido, permita a redefinição de senha

            // Lógica para processar o formulário de redefinição de senha
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm_password'];

                // Verificar se as senhas coincidem
                if ($password === $confirmPassword) {
                    // Hash da nova senha
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Atualizar a senha do usuário no banco de dados
                    $sql_update_password = "UPDATE adm SET senha_adm = :senha_adm WHERE token = :token";
                    $stmt_update_password = $pdo->prepare($sql_update_password);
                    $stmt_update_password->bindParam(':senha_adm', $hashedPassword);
                    $stmt_update_password->bindParam(':token', $token);
                    $stmt_update_password->execute();

                    // Remover o token do banco de dados após a redefinição da senha
                    $sql_delete_token = "DELETE FROM adm WHERE token = :token";
                    $stmt_delete_token = $pdo->prepare($sql_delete_token);
                    $stmt_delete_token->bindParam(':token', $token);
                    $stmt_delete_token->execute();

                    echo "Senha redefinida com sucesso!";
                } else {
                    echo "As senhas não coincidem.";
                }
            }
        } else {
            // O token expirou, exiba uma mensagem de erro apropriada
            echo "O token expirou. Por favor, solicite um novo link de redefinição de senha.";
        }
    } else {
        // Token inválido, exiba uma mensagem de erro apropriada
        echo "Token inválido. Por favor, verifique o link de redefinição de senha.";
    }
} else {
    // Caso o token não esteja presente na URL, redirecione o usuário para a página correta ou exiba uma mensagem de erro
    echo "Token ausente. Verifique o link de redefinição de senha fornecido.";
}
?>
