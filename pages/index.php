<?php
include_once("../php/session.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Fonotéka</title>
</head>

<body>
    <header>
        <a class="link_img" href="">
            <img class="img_logo" src="../assets/Logo.png" />Fonoteka
        </a>

        <div class="opcoes_div">
            <a href="#"> Home </a>
            <a href=""> Sobre nós </a>
            <a href=""> Aluno </a>
            <a href="./guia.php"> Guia </a>
        </div>

        <div class="div_usuario">
            <img id="perfil_usuario" class="img_perfil"
                src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : '../assets/perfil-Icon.png' ?>" />
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

    <main>
        <img class="capa" src="../assets/Carrossel.png">

        <!-- Ferramentas do Mentor -->

        <div class="areamentor">
            <p class="areaMentorTitulo"> Área do
            <p class="areaMentorTituloLaranja">Mentor </p>
            </p>
            <a href=""> <img class="interrogação" src="../assets/interrogação.png"> </a>
        </div>

        <div class="atividades">
            <div>
                <a href=""><img class="addatividade" src="../assets/ADICIONAR ATIVIDADE.png"></a>
            </div>

            <div>
                <a href=""><img class="progresso" src="../assets/progresso.png"></a>
                <a href=""><img class="naluno" src="../assets/Addaluno.png"></a>

            </div>

            <div>
                <a href="./atividades.php"><img class="controle" src="../assets/Atividade.png"></a>
                <a href="./guia.php"><img class="btnguia" src="../assets/guiatea.png"></a>

            </div>
        </div>

        <div class="retanguloazul">
            <a href="" class="alunoscad"> Ver Alunos Cadastrados </a>
        </div>
    </main>
</body>

<dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
</dialog>

<script src="../js/index.js"></script>

<?php

include('../php/conexao.php');
include('../php/login.php');

?>

</html>