<?php
include("conexao.php");
include("session.php");

$auth = $service->createAuth();

if (!empty($_POST['email']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = $service->initializeQueryBuilder();

    $user;

    try {
        $user = $query->select('*')
            ->from('tb_cadastro')
            // ->where('email', "$email")
            ->execute()
            ->getResult();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($user->num_rows == 1) {

        if (password_verify($senha, $user['Senha'])) {

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $user['IdMentor'];
            $_SESSION['nome'] = $user['Nome'];
            $_SESSION['funcao'] = $user['Funcao'];

            $idImagem = $user['IdImagem'];
            $idImagem = intval($idImagem);

            $sql = $conn->prepare("SELECT path FROM tb_Imagens WHERE IdImagem = ?");
            $sql->bind_param("i", $idImagem);
            $sql->execute();
            $result = $sql->get_result();

            $pathData = $result->fetch_assoc();
            if ($pathData) {
                $_SESSION['path_img'] = $pathData['path'];
            } else {
                $_SESSION['path_img'] = '';
            }
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
}

?>