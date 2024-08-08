<?php include_once ("./php/session.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Fonotéka</title>
</head>

<body>
    <header>
        <a class="link_img" href="">
            <img class="img_logo" src="assets/Logo.png" />Fonoteka
        </a>

        <div class="opcoes_div">
            <a href=""> Home </a>
            <a href=""> Sobre nós </a>
            <a href=""> Aluno </a>
            <a href="./guia.php"> Guia </a>
        </div>

        <div class="div_usuario">
            <img id="perfil_usuario" class="img_perfil" src="assets/perfil-Icon.png" />
            <label for="perfil_usuario" class="perfil_label">
                <?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?></label>
        </div>

        <form class="popLogin" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required disabled>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required disabled>
            <input type="submit" value="Acessar">
        </form>
    </header>

    <h1>Seja bem-vindo</h1>
    <a href="./php/logout.php">Sair</a>
</body>

<dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
</dialog>

<script src="./js/Modal.js"></script>

<script src="././js/popLogin.js"></script>

<?php

include ('./php/conexao.php');

if (!empty($_POST['email']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $email = $conn->real_escape_string($_POST['email']);
    $senha = $conn->real_escape_string($_POST['senha']);

    $sql = $conn->prepare("SELECT * FROM tb_cadastroMentor WHERE email=?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    $user = $result->fetch_assoc();

    if ($result->num_rows == 1) {

        if (password_verify($senha, $user['Senha'])) {

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $user['IdMentor'];
            $_SESSION['nome'] = $user['Nome'];

        } else {
            echo "<script>msg('SENHA INCORRETA!!')</script>";
        }

    } else {
        echo "<script>msg('EMAIL INCORRETO!!')</script>";
    }
}

?>

</html>