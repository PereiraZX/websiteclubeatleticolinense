<?php

    session_start();

    include_once("../../../api/connection/conn.php");

    $user_adm = filter_var($_POST['user_adm'], FILTER_SANITIZE_STRING);
    $senha_adm = $_POST['senha_adm'];

    $sql = "SELECT * FROM adm WHERE user_adm=:user_adm";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':user_adm', $user_adm);
    $stmt->execute();

    $dados_adm = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados_adm && password_verify($senha_adm, $dados_adm['senha_adm'])) {

        $_SESSION['id_adm'] = $dados_adm['id_adm'];
        $_SESSION['user_adm'] = $dados_adm['user_adm'];

        header("Location: ../../../cms.php");

        exit();
    } else {
        $error_message = 'Usuário ou senha inválidos.';
        echo $error_message;
    }

?>