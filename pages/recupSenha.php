<?php
include_once ("../php/conexao.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Esqueceu a senha</title>
</head>

<body>
    <main class="cont_form">
        <h1>Recuperar Senha</h1>
        <form class="form_recuperar" method="POST">
            <input type="password" name="novaSenha" placeholder="Digite a nova senha">
            <input type="submit" value="Atualizar" name="SendnovaSenha">
            <a href="/index.php">Lembrou?</a>
        </form>
    </main>
    <?php
        $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);

        if(!empty($chave)){
            $sql = $conn->prepare("SELECT IdMentor FROM tb_cadastro WHERE recuperarSenha = ? LIMIT 1");
            $sql->bind_param("s", $chave);
            $sql->execute();
            $result = $sql->get_result();
    
            if(($result) AND $result->num_rows == 1){
                $user_row = $result->fetch_assoc();
                $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if(!empty($dados['SendnovaSenha'])){
                    $senha_usuario = password_hash($dados['novaSenha'], PASSWORD_DEFAULT);

                    $sql = $conn->prepare("UPDATE tb_cadastro SET Senha = ?, recuperarSenha = NULL WHERE IdMentor = ?");
                    $sql->bind_param("ss", $senha_usuario, $user_row['IdMentor']);

                    if($sql->execute()){
                        echo "senha atualizada";
                        header("Location: ./esqSenha.php");
                    } else {
                        echo "erro 5";
                    }
                }
            } else {
                echo "erro 3";
                header("Location: ./esqSenha.php");
            }
        } else {
            echo "erro 4";
            header("Location: ./esqSenha.php");
        }

    ?>
</body>
</html>