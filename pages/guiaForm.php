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
    <form enctype="multipart/form-data" class="form-guia" method="POST">
        <h1>Adicione um guia</h1>

        <div>
            <p>Titulo:</p>
            <input type="text" name="titulo" autocomplete="off" placeholder="Digite o Titulo" maxlength="50" autofocus
                required>
        </div>

        <div>
            <p>Descrição:</p>
            <input type="text" name="desc" autocomplete="off" placeholder="Digite a descrição" maxlength="100" required>
        </div>

        <div>
            <p>Autor:</p>
            <input type="text" name="autor" autocomplete="off" placeholder="Digite o autor" maxlength="50" required>
        </div>

        <div>
            <p>Imagem:</p>
            <input type="file" name="imagem" required>
        </div>

        <div class="div_form">
            <input class="button_cadastro" id="buSubmit" type="submit" value="Cadastrar">
        </div>
    </form>

    <?php
    include_once('../php/conexao.php');

    if (isset($_POST['titulo']) && isset($_POST['autor']) && isset($_POST['desc']) && isset($_FILES['imagem'])) {

        $titulo = $_POST['titulo'];
        $descricao = $_POST['desc'];
        $autor = $_POST['autor'];
        $imagem = $_FILES['imagem'];

        if ($imagem['error'])
            die("Erro ao carregar a imagem");

        if ($imagem['size'] > 2097152)
            die("Arquivo muito pesado");

        $nomeImagem = $imagem['name'];
        $uniqId = uniqid();
        $extensaoImagem = strtolower(pathinfo($nomeImagem, PATHINFO_EXTENSION));

        if ($extensaoImagem != "jpg" && $extensaoImagem != "png" && $extensaoImagem != "jpeg")
            die("<script>msgPop('Formato não suportado');</script>");

        $path = "../images/" . $uniqId . "." . $extensaoImagem;

        $moved = move_uploaded_file($imagem['tmp_name'], $path);

        if ($moved) {
            $sql = $conn->prepare("SELECT nomeGuia FROM tb_guias WHERE nomeGuia =?");
            $sql->bind_param('s', $titulo);
            $sql->execute();

            $result = $sql->get_result();

            if (mysqli_num_rows($result) > 0) {
                echo ("<script>msgPop('Guia já cadastrado');</script>");
            } else {
                $sql_query = $conn->query("INSERT INTO tb_imagens(nomeImagem,path)VALUES('$nomeImagem', '$path')") or die("Erro ao inserir a imagem");

                $sql_query = $conn->query("SELECT IdImagem FROM tb_imagens WHERE path = '$path'") or die("Erro ao inserir o jogo");

                $idImagem = $sql_query->fetch_array();
                $idImagem = $idImagem['IdImagem'];

                $sql_query = $conn->query("INSERT INTO tb_guias (nomeGuia, descricao, nomeAutor, IdImagem) VALUES('$titulo','$descricao','$autor', '$idImagem')") or die("Erro ao inserir o jogo");

                echo ("<script>msgPop('Cadastro efetuado com sucesso!!');</script>");
            }
        } else {
            echo ("<script>msgPop('Erro ao mover a imagem para a pasta');</script>");
        }
    }

    ?>
</body>

</html>