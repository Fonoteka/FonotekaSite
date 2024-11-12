<?php
include_once("../php/conexao.php");
include_once("../php/session.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../lib/vendor/autoload.php';

$mail = new PHPMailer(true);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Esqueceu a senha</title>
</head>

<body class="esqSenha_body">
    <main class="cont_form">
        <h1>Recuperação de conta</h1>
        <form class="form_recuperar" method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="submit" value="Recuperar" name="SendGeraSenha">
            <a href="./index.php">Lembrou?</a>
            <p id="msg"></p>
        </form>
    </main>
</body>

<script src="../js/index.js"></script>

<?php

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['SendGeraSenha'])) {
    $email = $_POST['email'];

    $queryRecupera = $service->initializeQueryBuilder();

    try {
        $recupera = $queryRecupera->select("idmentor, nome, email, telefone")
            ->from("tb_cadastro")
            ->where("email", "eq.$email")
            ->range("0-1")
            ->execute()
            ->getResult();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }

    if ($recupera) {
        $chave_recupera_senha = password_hash($recupera[0]->idmentor, PASSWORD_DEFAULT);

        $db = $service->initializeDatabase("tb_cadastro", "idmentor");

        $updateRecupera = [
            "recuperarsenha" => $chave_recupera_senha
        ];

        try {
            $data = $db->update($recupera[0]->idmentor, $updateRecupera);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }

        if ($data) {
            $link = "http://localhost/fonotekaSite/pages/recupSenha.php?chave=$chave_recupera_senha";

            try {
                $mail->CharSet = "UTF-8";
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'bancodesanguetcc03@gmail.com';
                $mail->Password = 'nduaohkoqwgcfmav';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('atendimento@fonoteka.com', 'atendimento');
                $mail->addAddress($recupera[0]->email, $recupera[0]->nome);

                $mail->isHTML(true);
                $mail->Subject = 'Recuperar a senha - Fonoteka';
                $mail->Body = "Prezado(a) " . $recupera[0]->nome . "<br><br>Recebemos uma solicitação para redefinir a senha da sua conta. Para prosseguir com a alteração, por favor, <b>clique no link abaixo:</b> <br><br> <a href=" . $link . ">Redefinir senha</a> <br><br>Por questões de segurança, este link é válido apenas uma vez. Se você não solicitou a redefinição da senha, desconsidere este email. Sua conta permanecerá segura. <br><br> Atenciosamente,<br>Iniciativa Fonoteka";
                $mail->AltBody = $link;

                $mail->send();

                $_SESSION['msgTexto'] = "<script>msgTexto('<p>Email enviado com sucesso!!</p>')</script>";
            } catch (Exception $e) {
                $_SESSION['msgTexto'] = "<script>msgTexto('<p>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>')</script>";
                exit();
            } finally {
                header("Location: " . $_SERVER['PHP_SELF']);
                $dados = array();
                exit();
            }
        } else {
            $_SESSION['msgTexto'] = "<script>msgTexto('<p>ERRO: Não foi possivel atualizar o recuperar Senha</p>')</script>";
        }
    } else {
        $_SESSION['msgTexto'] = "<script>msgTexto('<p>ERRO: Email não encontrado no banco de dados</p>')</script>";
    }
}

echo !empty($_SESSION['msgTexto']) ? $_SESSION['msgTexto'] : "";
$_SESSION['msgTexto'] = "";
?>

</html>