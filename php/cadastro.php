<?php

include('conexao.php');
include("session.php");

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['SendNovoUsuario'])) {
    $nome = $dados['nome'];
    $usuario = $dados['usuario'];
    $email = $dados['email'];

    $obj_nascimento = new DateTime($dados['nascimento']);
    $nascimento = $obj_nascimento->format('Y-m-d');
    $genero = $dados['genero'];
    $tel = $dados['telefone'];
    $senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
    $senhaDescriptografada = $dados['senha'];
    $confSenha = $dados['confSenha'];
    $politicas = $dados['politicas'];


    $hoje = new DateTime(date('Y/m/d'));
    $diff = $hoje->diff($obj_nascimento);
    $diff = $diff->y;

    $db = $service->initializeDatabase('tb_cadastro', 'idmentor');

    if ($senhaDescriptografada === $confSenha) {
        $queryVerifyUser = $service->initializeQueryBuilder();

        if ($diff >= 18) {
            $userExist;
            try {
                $userExist = $queryVerifyUser->select('idmentor, nome')
                    ->from('tb_cadastro')
                    ->where('email', "eq.$email")
                    ->execute()
                    ->getResult();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            var_dump($userExist);
            if ($userExist) {
                $_SESSION['msgCadastro'] = "<script>msgPop('Usuário já cadastrado');</script>";
            } else {

                $newUser = [
                    'nome' => $nome,
                    'email' => $email,
                    'telefone' => $tel,
                    'senha' => $senha,
                    'usuario' => $usuario,
                    'datanascimento' => $nascimento,
                    'genero' => $genero,
                    'funcao' => "FALSE",
                    'idimagem' => null,
                    'recuperarsenha' => null

                ];

                try {
                    $data = $db->insert($newUser);
                    $_SESSION['msgCadastro'] = "<script>msgPop('Usuário cadastrado');</script>";
                } catch (Exception $e) {
                    echo $e->getMessage();
                    $_SESSION['msgCadastro'] = "<script>msgPop('ERRO: Problema de inserção no banco de dados');</script>";
                }
            }
        } else {
            $_SESSION['msgCadastro'] = "<script>msgPop('Idade minima não atendida');</script>";
        }
    } else {
        $_SESSION['msgCadastro'] = "<script>msgPop('As senhas não coincidem');</script>";
    }
    header("Location: ../pages/cadastro.php");
}