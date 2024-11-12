<?php
include_once("../php/session.php");
include_once("../php/protect.php");
protectAdm(1);
?>

<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script src="https://unpkg.com/@supabase/supabase-js@2"></script>


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
    <form enctype="multipart/form-data" class="form-guia" id="form-guia">
        <h1>Adicione um guia</h1>

        <div>
            <p>Titulo:</p>
            <input type="text" id="titulo" autocomplete="off" placeholder="Digite o Titulo" maxlength="50" autofocus
                required>
        </div>

        <div>
            <p>Descrição:</p>
            <input type="text" id="desc" autocomplete="off" placeholder="Digite a descrição" maxlength="100" required>
        </div>

        <div>
            <p>Autor:</p>
            <input type="text" id="autor" autocomplete="off" placeholder="Digite o autor" maxlength="50" required>
        </div>

        <div>
            <p>Link:</p>
            <input type="text" id="link" autocomplete="off" placeholder="Digite o link" required>
        </div>

        <div>
            <p>Imagem:</p>
            <input type="file" id="imagem" accept="image/*" required>
        </div>

        <div class="div_form">
            <input class="button_cadastro" id="buSubmit" name="SendNewGuia" type="submit" value="Cadastrar">
        </div>
    </form>


    <dialog>
        <h1 id="msgCadastro"></h1>
        <button id="buClose" class="buClose">Fechar</button>
    </dialog>

</body>
<script src="../js/index.js"></script>
<script src="../js/storage-guia.js"></script>

<?php
echo !empty($_SESSION['msgGuia']) ? $_SESSION['msgGuia'] : "";
$_SESSION['msgGuia'] = "";
?>

</html>