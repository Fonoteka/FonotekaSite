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
            $_SESSION['funcao'] = $user[0]->funcao;

            $idImagem = $user[0]->idimagem;
            $idImagem = intval($idImagem);

            $queryPath = $service->initializeQueryBuilder();

            try {
                $path = $queryPath->select('path')
                    ->from('tb_imagens')
                    ->where('idimagem', "eq.$idImagem")
                    ->execute()
                    ->getResult();
            } catch (Exception $e) {
                echo $e->getMessage();
                exit();
            }

            if ($path) {
                $_SESSION['path_img'] = $path[0]->path;
            } else {
                $_SESSION['path_img'] = 'NULO';
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
