<?php
include_once("./php/session.php");
?>
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
            <img id="perfil_usuario" class="img_perfil"
                src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : 'assets/perfil-Icon.png' ?>" />
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













<script src="./js/Modal.js"></script>

<script src="././js/popLogin.js"></script>

<?php

include('./php/conexao.php');
include('./php/login.php');

?>

</html>