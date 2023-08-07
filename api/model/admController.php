<?php
    include_once("../connection/conn.php");

    $requestData = $_REQUEST;

    // CRUD ADMINISTRADOR

    // CREATE
    if ($requestData["operation"] == "create") {
        if (
            empty($requestData["user_adm"]) || 
            empty($requestData["email_adm"]) ||
            empty($requestData["senha_adm"])
            ) {
            $dados = array(
                "type" => "error",
                "mensagem" => "Existe(m) campo(s) obrigatório(s) não preenchido"
            );
        } else {
            try {

                // Verifica se o usuario já existe no banco de dados
                $sql_check_email = "SELECT * FROM adm WHERE user_adm = :user_adm";
                $stmt_check_email = $pdo->prepare($sql_check_email);
                $stmt_check_email->bindParam(":user_adm", $user_adm);
                $stmt_check_email->execute();
    
                if ($stmt_check_email->rowCount() > 0) {
                    // E-mail já está cadastrado, exiba uma mensagem de erro ou tome outra ação necessária
                    echo "Usúario já existe";
                    exit();
                }

                // Verifica se o e-mail já existe no banco de dados
                $sql_check_email = "SELECT * FROM adm WHERE email_adm = :email";
                $stmt_check_email = $pdo->prepare($sql_check_email);
                $stmt_check_email->bindParam(":email", $email_adm);
                $stmt_check_email->execute();
                
                if ($stmt_check_email->rowCount() > 0) {
                    // E-mail já está cadastrado, exiba uma mensagem de erro ou tome outra ação necessária
                    echo "O e-mail já está cadastrado.";
                    exit();
                }

                // Criptografa a senha usando a função password_hash
                $senha_hash = password_hash($requestData["senha_adm"], PASSWORD_DEFAULT);


                // Inserindo usuário no banco de dados
                $sql = "INSERT INTO adm (user_adm, email_adm, senha_adm ) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $requestData["user_adm"],
                    $requestData["email_adm"],
                    $senha_hash
                ]);

                $dados = array(
                    "type" => "success",
                    "mensagem" => "Registro salvo com sucesso!"
                );

                header('Location: ../../assets/login/view/loginAdm.html');

            } catch (PDOException $e) {
                $dados = array(
                    "type" => "error",
                    "mensagem" => "Erro ao salvar o registro: " . $e
                );
            }
        }
    }
    // READ
    if ($requestData["operation"] == "read") {

        $sql = "SELECT * FROM adm";
        $result = $pdo->query($sql);

        try {
            if ($result) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $dados[] = array_map(null, $row);
                }
            } else {
                $dados = array (
                    "Mensagem" => "Não foi encontrado nenhum registro!"
                );
            }
        } catch (PDOException $e) {
            $dados = array (
                "type" => "error",
                "mensagem" => "Erro ao buscar registros: " . $e
            );
        }
    }

    echo json_encode($dados);

?>
