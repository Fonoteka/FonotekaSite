<?php

include('conexao.php');
include("session.php");

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);
if (!empty($dados["newAluno"])) {
    $nome = $dados["nome"];
    $nivel = $dados["nivel"];
    $usuario = $dados["usuario"];
    $genero = $dados["genero"];
    $email = $dados["email"];
    $senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
    $senhaDescriptografada = $dados["senha"];
    $idMentor = $_SESSION['id'];

    $queryVerifyAluno = $service->initializeQueryBuilder();

    try {
        $alunoExist = $queryVerifyAluno->select('idaluno, nome')
            ->from('tb_cadastroaluno')
            ->where('email', "eq.$email")
            ->execute()
            ->getResult();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }

    var_dump($alunoExist);

    if (!$alunoExist) {
        $db = $service->initializeDatabase('tb_cadastroaluno', 'idaluno');

        $newAluno = [
            "nome" => $nome,
            "usuario" => $usuario,
            "email" => $email,
            "senha" => $senha,
            "genero" => $genero,
            "nivelautismo" => $nivel,
            "idmentor" => $idMentor,
        ];

        try {
            $data = $db->insert($newAluno);
            $_SESSION['msgCadastroAluno'] = "<script>msgPop('Aluno cadastrado');</script>";
        } catch (Exception $e) {
            echo $e->getMessage();
            $_SESSION['msgCadastroAluno'] = "<script>msgPop('ERRO: Problema de inserção no banco de dados');</script>";
        }
    } else {
        $_SESSION["msgCadastroAluno"] = "<script>msgPop('Aluno já está cadastrado');</script>";
    }
    $dados = array();
    header("Location: ../pages/cadastroAluno.php");
    exit();
}