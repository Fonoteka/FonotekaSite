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

<body>
    <main class="cont_form">
        <h1>Recuperação de conta</h1>
        <form class="form_recuperar" method="POST">
            <input type="text" name="recupera" placeholder="Email, cpf ou telefone">
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
    $recupera = $_POST['recupera'];

    $sql_query = "SELECT IdMentor, nome, email, Telefone FROM tb_cadastro WHERE email = ? LIMIT 1";
    $sql = $conn->prepare($sql_query);
    $sql->bind_param("s", $recupera);
    $sql->execute();
    $result = $sql->get_result();

    if (($result->num_rows == 1) and ($recupera)) {
        $user_row = $result->fetch_assoc();
        $chave_recupera_senha = password_hash($user_row['IdMentor'], PASSWORD_DEFAULT);
        $sql = $conn->prepare("UPDATE tb_cadastro SET recuperarSenha = ? WHERE IdMentor = ?");
        $sql->bind_param("ss", $chave_recupera_senha, $user_row['IdMentor']);

        if ($sql->execute()) {
            $link = "http://localhost/fonotekaSite/pages/recupSenha.php?chave=$chave_recupera_senha";

            try {
                $mail->CharSet = "UTF-8";
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'bancodesanguetcc03@gmail.com';
                $mail->Password = 'ywxwwqscovsgvwca';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('atendimento@fonoteka.com', 'atendimento');
                $mail->addAddress($user_row['email'], $user_row['nome']);

                $mail->isHTML(true);
                $mail->Subject = 'Recuperar a senha - Fonoteka';
                $mail->Body    = "Prezado(a) ". $user_row['nome'] . "<br><br>Recebemos uma solicitação para redefinir a senha da sua conta. Para prosseguir com a alteração, por favor, <b>clique no link abaixo:</b> <br><br> <a href=" . $link . ">Redefinir senha</a> <br><br>Por questões de segurança, este link é válido apenas uma vez. Se você não solicitou a redefinição da senha, desconsidere este email. Sua conta permanecerá segura. <br><br> Atenciosamente,<br>Iniciativa Fonoteka" ;
                $mail->AltBody = $link;

                $mail->send();

            } catch (Exception $e) {
                echo "<script>msgTexto(\"<p>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>\")</script>";
            }
        } else {
            echo "<script>msgTexto('<p>ERRO: Não foi pussivel atualizar o recuperar Senha</p>')</script>";
        }
    } else {
        echo "<script>msgTexto('<p>ERRO: Email não encontrado no banco de dados</p>')</script>";
    }
}
?>

</html>