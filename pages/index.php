<?php
include_once("../php/session.php");
echo $_SESSION['path_img'];
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
        <a class="link_img" href="./index.php">
            <img class="img_logo" src="../assets/Logo.png" />Fonoteka
        </a>

        <div class="opcoes_div">
            <a href="./index.php"> Home </a>
            <a href="./sobrenos.php"> Sobre nós </a>
            <a href=""> Aluno </a>
            <a href="./guia.php"> Guia </a>
        </div>

        <div class="div_usuario">
            <img id="perfil_usuario" class="img_perfil"
                src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : '../assets/perfil-Icon.png' ?>" />
            <label for="perfil_usuario" class="perfil_label">
                <?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?>
            </label>
        </div>

        <?php
        echo "<form class=\"popLogin\" action=\"../php/login.php\" method=\"POST\">";
        if (isset($_SESSION['id'])) {
            echo "<button class=\"alt_cont\">Configurações conta</button>";
            echo "<a class=\"btn_logout\" href=\"./logout.php\">Sair</a>";
        } else {
            echo "<label for=\"email\">Email:</label>";
            echo "<input type=\"email\" id=\"email\" name=\"email\" required disabled>";
            echo "<label for=\"senha\">Senha:</label>";
            echo "<input type=\"password\" id=\"senha\" name=\"senha\" required disabled>";
            echo "<a class=\"link_popLogin\" href=\"./esqSenha.php\">Esqueceu a senha?</a>";
            echo "<input class=\"btn_login\" type=\"submit\" value=\"Acessar\">";
            echo "<a class=\"link_popLogin\" href=\"./cadastro.php\">Sem conta?</a>";
        }
        echo "</form>";
        ?>

        <img class="menu_hamburguer" src="../assets/menu.png" alt="">
        <nav>

            <section>
                <div class="menu_opcoes_div">
                    <a href="./index.php"> Home </a>
                    <a href="./sobrenos.php"> Sobre nós </a>
                    <a href=""> Aluno </a>
                    <a href="./guia.php"> Guia </a>
                </div>
                <hr>
                <div class="menu_div_usuario">
                    <img id="perfil_usuario" class="img_perfil"
                        src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : '../assets/perfil-Icon.png' ?>" />
                    <label for="perfil_usuario" class="perfil_label">
                        <?php echo !empty($_SESSION['id']) ? $_SESSION['nome'] : "Usuário"; ?>
                    </label>
                </div>
            </section>

        </nav>
    </header>

    <main>
        <img class="capa" src="../assets/Carrossel.png">

        <!-- Ferramentas do Mentor -->

        <div class="areamentor">
            <p class="areaMentorTitulo"> Área do <span class="areaMentorTituloLaranja">Mentor</span></p>
            <a href="./ajuda.php"> <img class="interrogação" src="../assets/interrogação.png"> </a>
        </div>

        <div class="atividades">
            <div>
                <a href="./adicionarAtividade.php"><img class="addatividade"
                        src="../assets/ADICIONAR ATIVIDADE.png"></a>
            </div>

            <div>
                <a href=""><img class="progresso" src="../assets/progresso.png"></a>
                <a href="./cadastroAluno.php"><img class="naluno" src="../assets/Addaluno.png"></a>

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

echo !empty($_SESSION['msgLogin']) ? $_SESSION['msgLogin'] : "";
$_SESSION['msgLogin'] = "";

?>

</html>
