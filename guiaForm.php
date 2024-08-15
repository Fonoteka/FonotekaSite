<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #c1e5f5;
        }
    </style>
</head>

<body>

    <form enctype="multipart/form-data" class="form-cad" method="POST">
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
    include_once('./php/conexao.php');

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
            die("Formato não suportado");

        $path = "./images/" . $uniqId . "." . $extensaoImagem;

        $moved = move_uploaded_file($imagem['tmp_name'], $path);

        if ($moved) {
            $sql = $conn->prepare("SELECT nomeGuia FROM tb_guias WHERE nomeGuia =?");
            $sql->bind_param('s', $titulo);
            $sql->execute();

            $result = $sql->get_result();

            if (mysqli_num_rows($result) > 0) {
                echo ("<script>msg('Guia já cadastrado');</script>");
            } else {
                $sql_query = $conn->query("INSERT INTO tb_imagens(nomeImagem,path)VALUES('$nomeImagem', '$path')") or die("Erro ao inserir a imagem");

                $sql_query = $conn->query("SELECT IdImagem FROM tb_imagens WHERE path = '$path'") or die("Erro ao inserir o jogo");

                $idImagem = $sql_query->fetch_array();
                $idImagem = $idImagem['IdImagem'];

                $sql_query = $conn->query("INSERT INTO tb_guias (nomeGuia, descricao, nomeAutor, IdImagem) VALUES('$titulo','$descricao','$autor','$idImagem')") or die("Erro ao inserir o jogo");

                echo ("<script>msg('Cadastro efetuado com sucesso!!');</script>");
            }
        } else {
            echo "Erro ao mover a imagem para a pasta";
        }
    }

    ?>
</body>

</html>