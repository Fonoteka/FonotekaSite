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
    <title> Adicionar Atividades </title>
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
    <form enctype="multipart/form-data" method="POST" class="fundo">
        <div class="containerimagem">
            <img class="imagem" src="../assets/Adicionarativ.png">
            <input class="bntadd" type="submit" name="sendAtividade" value="Adicionar" required>
        </div>

        <div class="containertexto">
            <input class="titulotext" type="text" id="titulo" placeholder="Nome da atividade:" name="nomeAtividade"
                required>
            <p class="obs"> Abaixo adicione as informações de forma curta para execução da atividade</p>
            <input class="obsadd" type="text" placeholder="Adicionar descrição" name="descAtividade" required>

        </div>

        <div class="containeradicional">
            <input class="pontos" type="number" placeholder="Qtd Pontos" name="pontos" required>
            <input class="pontos" type="number" placeholder="Nível Autismo" name="nivelAutismo" required>
            <input class="pontos" type="date" placeholder="Data Inicial (Mentor)" name="dataPostagem" required>
            <input class="pontos" type="datetime-local" placeholder="Data Final (Aluno)" name="dataEntrega" required>
            <input class="pontos" type="number" placeholder="ID Aluno" name="idAluno" required>

        </div>
    </form>

</body>

<dialog>
    <h1 id="msgCadastro"></h1>
    <button id="buClose" class="buClose">Fechar</button>
</dialog>

<script src="../js/index.js"></script>

<?php


include('../php/conexao.php');
include('../php/login.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['sendAtividade'])) {


    $nomeAtividade = $dados['nomeAtividade'];
    $descAtividade = $dados['descAtividade'];
    $pontos = $dados['pontos'];
    $nivelAutismo = $dados['nivelAutismo'];
    $dataPostagem = $dados['dataPostagem'];
    $dataEntrega = $dados['dataEntrega'];
    $IdAluno = $dados['idAluno'];
    $IdMentor = $_SESSION['id'];
    $arquivo = $_FILES['arquivo'];
    $IdGroup = uniqid();

    foreach ($arquivo['error'] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $nomeArquivo = $arquivo['name'][$key];
            $uniqId = uniqid();
            $extensaoArquivo = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

            $path = "../files/" . $uniqId . "." . $extensaoArquivo;

            $moved = move_uploaded_file($arquivo['tmp_name'][$key], $path);

            if ($moved) {
                $sql_query = "INSERT INTO tb_arquivos (IdGroup, nomeArquivo, pathArquivo) VALUES (?,?,?)";
                $sql = $conn->prepare($sql_query);
                $sql->bind_param("sss", $IdGroup, $nomeArquivo, $path);
                if (!($sql->execute())) {
                    die("ERRO: Não foi possivel inserir o arquivo $nomeArquivo");
                }
            } else {
                die("<script>msgPop(ERRO: Não foi possivel mover os arquivos para a pasta');</script>");
            }
        } else {
            die("<script>msgPop(ERRO: Não foi possivel dar upload');</script>");
        }
    }

    $sql_query = "INSERT INTO tb_atividades (nomeAtividade, descAtividade, IdMentor, qtnPontos, nivelAutismo, dataPostagem , dataEntrega, IdGroup, IdAluno) VALUES (?,?,?,?,?,?,?,?,?)" or die("<script>msgPop('ERRO: Não foi possivel inserir arquivo');</script>");
    $sql = $conn->prepare($sql_query);
    $sql->bind_param("sssssssss", $nomeAtividade, $descAtividade, $IdMentor, $pontos, $nivelAutismo, $dataPostagem, $dataEntrega, $IdGroup, $IdAluno);
    if ($sql->execute()) {
        echo ("<script>msgPop('Atividade cadastrada com sucesso');</script>");
        $sql_query = "";
    } else {
        echo ("<script>msgPop('ERRO: Não foi possivel cadastrar atividade');</script>");
        $sql_query = "";
    }

    $dados = array();
}

echo !empty($_SESSION['msgLogin']) ? $_SESSION['msgLogin'] : "";
$_SESSION['msgLogin'] = "";

?>

</html>
