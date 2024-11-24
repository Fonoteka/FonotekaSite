<?php
include("conexao.php");
include("session.php");





$auth = $service->createAuth();

if (!empty($_POST['email']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];   


    $queryUser = $service->initializeQueryBuilder();

    $user;

    try {
        $user = $queryUser->select('*')
            ->from('tb_cadastro')
            ->where('email', "eq.$email")
            ->execute()
            ->getResult();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }

    if (is_array($user)) {

        if (password_verify($senha, $user[0]->senha)) {

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $user[0]->idmentor;
            $_SESSION['nome'] = $user[0]->nome;
            $_SESSION['telefone'] = $user[0]->telefone;

            $_SESSION['funcao'] = $user[0]->funcao;
            $_SESSION['path_img'] = $user[0]->path_imagem;
            

            $id = $_SESSION['id'];
            $_SESSION['msgLogin'] = "<script>localStorage.setItem(\"idMentor\", $id)</script>";

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();

        } else {
            $_SESSION['msgLogin'] = "<script>msgPop('ERRO: Senha Incorreta!!');</script>";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }

    } else {
        $_SESSION['msgLogin'] = "<script>msgPop('ERRO: Email Incorreto!!');</script>";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }


};

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
    <title> Perfil do mentor  </title>
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

            <p class="fundo1"><?php echo "Olá, " . (isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Não disponível');?></p>
            <div class="infoatual">
            <p><?php echo "ID Mentor: " . (isset($_SESSION['id']) ? $_SESSION['id'] : 'Não disponível'); ?></p>
            <p><?php echo "Nome de Usuário: " . (isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Não disponível'); ?></p>
            <p><?php echo "Email: " . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Não disponível'); ?></p>
            <p><?php echo "Telefone: " . (isset($_SESSION['telefone']) ? $_SESSION['telefone'] : 'Não disponível'); ?></p>
            <p><?php echo "Data Nascimento: " . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Não disponível'); ?></p>
            <p><?php echo "Genêro: " . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Não disponível'); ?></p>
            </div>
    </body>
</html>
