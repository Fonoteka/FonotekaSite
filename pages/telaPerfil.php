<?php
include_once("../php/session.php");
include_once("../php/conexao.php");

$queryPath = $service->initializeQueryBuilder();

$id = $_SESSION['id'];

try {
    $path = $queryPath->select('path_imagem')
        ->from('tb_cadastro')
        ->where('idmentor', "eq.$id")
        ->execute()
        ->getResult();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$_SESSION['path_img'] = $path[0]->path_imagem
    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script src="https://unpkg.com/@supabase/supabase-js@2"></script>
    <title> Perfil do mentor </title>
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

    <h1 class="tituloPerfil">Configurações de Perfil</h1>
    <section class="info">
        <div class="info_imagem">
            <img
                src="<?php echo !empty($_SESSION['path_img']) ? $_SESSION['path_img'] : '../assets/perfil-Icon.png' ?>">
            <input class="file file_mentor" type="file" id="file">
        </div>
        <div class="info_dados">
            <label for="nome">Nome de Usuário:</label>
            <input type="text" id="nome"
                value="<?php echo !empty($_SESSION['nome']) ? $_SESSION['nome'] : 'Não disponível' ?>">
            <label for="email">Email:</label>
            <input type="text" id="email"
                value="<?php echo !empty($_SESSION['email']) ? $_SESSION['email'] : 'Não disponível' ?>">
            <label for="email">Telefone:</label>
            <input type="text" id="telefone"
                value="<?php echo !empty($_SESSION['telefone']) ? $_SESSION['telefone'] : 'Não disponível' ?>">
            <label for="email">Genero:</label>
            <input type="text" id="genero"
                value="<?php echo !empty($_SESSION['genero']) ? $_SESSION['genero'] : 'Não disponível' ?>">
        </div>
        <input id="btnSalvar" type="button" value="Salvar">
    </section>
    <div class="loader loader-hidden"></div>

</body>

<dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
</dialog>

<script src="../js/index.js"></script>
<script src="../js/data-telaMentor.js"></script>

</html>