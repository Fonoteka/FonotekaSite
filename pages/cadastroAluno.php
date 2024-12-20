<?php
include_once("../php/session.php");
include_once("../php/protect.php");
protectAdm(0);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <title> Cadastrar Aluno </title>
</head>

<body>
    <header>
        <a class="link_img" href="./index.php">
            <img class="img_logo" src="../assets/Logo.png" />Fonoteka
        </a>

        <div class="opcoes_div">
            <a href="./index.php"> Home </a>
            <a href="./sobrenos.php"> Sobre nós </a>
            <a href="./atividades.php"> Aluno </a>
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
            echo "<a class=\"alt_cont\" href=\"./telaPerfil.php\">Configurações conta</a>";
            echo "<a class=\"btn_logout\" href=\"./logout.php\">Sair</a>";
        } else {
            echo "<label for=\"email\">Email:</label>";
            echo "<input type=\"email\" id=\"email\" name=\"email\" required disabled>";
            echo "<label for=\"senha\">Senha:</label>";
            echo "<input type=\"password\" id=\"senha\" name=\"senha\" required disabled>";
            echo "<a class=\"link_popLogin\" href=\"./esqSenha.php\">Esqueceu a senha?</a>";
            echo "<input class=\"alt_cont\" type=\"submit\" value=\"Acessar\">";
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
                    <a href="./atividades.php"> Aluno </a>
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
    <form class="formAluno" action="../php/cadastraAluno.php" method="POST">
        <img class="containerimagem_aluno" src="../assets/perfilaluno.jpg">

        <div class="containertexto_aluno">
            <input class="titulotext_aluno" type="text" name="nome" placeholder="Nome completo aluno:">
            <input class="titulotext_aluno" type="number" name="nivel" placeholder="Nível de Autismo do aluno:">
            <input class="titulotext_aluno" type="text" name="usuario" placeholder="Usuário do aluno:">
            <select class="titulotext_aluno" name="genero">
                <option value="">Selecione o gênero</option>
                <option value="homem">Homem</option>
                <option value="mulher">Mulher</option>
                <option value="mulher">Não-binário</option>
                <option value="mulher">Não Informar</option>
            </select>
            <input class="titulotext_aluno" type="email" name="email" placeholder="E-mail Aluno:">
            <input class="titulotext_aluno" type="password" name="senha" placeholder="Senha do aluno:">
        </div>
        <input class="bntadd_aluno" type="submit" name="newAluno" value="Cadastrar Aluno">
    </form>

</body>

<dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
</dialog>

<script src="../js/index.js"></script>

<?php

echo !empty($_SESSION['msgCadastroAluno']) ? $_SESSION['msgCadastroAluno'] : "";
$_SESSION['msgCadastroAluno'] = "";

?>

</html>