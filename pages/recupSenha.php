<?php
include_once("../php/conexao.php");
include_once("../php/session.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Recuperar a senha</title>
</head>

<body>
    <main class="cont_form">
        <h1>Resetar Senha</h1>
        <form class="form_recuperar" method="POST">
            <input type="password" name="novaSenha" placeholder="Digite a nova senha" required>
            <input type="submit" value="Atualizar" name="SendnovaSenha">
            <a href="./index.php">Lembrou?</a>
            <div id="msg"></div>
        </form>
    </main>

    <dialog>
        <h1 id="msgCadastro"></h1>
        <button id="buClose" class="buClose">Fechar</button>
    </dialog>
</body>
<?php
$chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);

if (!empty($chave)) {
    $queryIdMentor = $service->initializeQueryBuilder();

    $idmentor = $queryIdMentor->select("idmentor")
        ->from("tb_cadastro")
        ->where("recuperarsenha", "eq.$chave")
        ->range("0-1")
        ->execute()
        ->getResult();

    if ($idmentor) {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dados['SendnovaSenha'])) {
            $senha_usuario = password_hash($dados['novaSenha'], PASSWORD_DEFAULT);

            $db = $service->initializeDatabase("tb_cadastro", "idmentor");

            $updateSenha = [
                "senha" => $senha_usuario,
                "recuperarsenha" => null
            ];

            try {
                $data = $db->update($idmentor[0]->idmentor, $updateSenha);
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }

            if ($data) {
                $_SESSION['msgLogin'] = "<script>msgPop('<p>Senha atualizada com sucesso</p>')</script>";
                header("Location: ./index.php");
            } else {
                $_SESSION['msgTexto'] = "<script>msgTexto('<p>Erro ao atualizar senha</p>')</script>";
                header("Location: ./esqSenha.php");
            }
        }
    } else {
        $_SESSION['msgTexto'] = "<script>msgTexto('<p>ERRO: Chave inválida</p>')</script>";
        header("Location: ./esqSenha.php");
    }
} else {
    $_SESSION['msgTexto'] = "<script>msgTexto('<p>ERRO: Link inválido</p>')</script>";
    header("Location: ./esqSenha.php");
}

?>

</html>