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
    <h1>Recuperação de conta</h1>
    <form method="POST">
        <input type="text" name="recupera" placeholder="Email, cpf ou telefone">
        <input type="submit" value="Recuperar">
        <a href="/index.php">Lembrou?</a>
    </form>
</body>

<?php
include_once("../php/conexao.php");


if (!empty($recupera)) {
    var_dump($recupera);
    $recupera = $_POST['recupera'];

    $sql_query = "SELECT IdMentor, nome, email,Telefone FROM tb_cadastro WHERE email = ?email LIMIT 1";
    $sql = $conn->prepare($sql_query);
    $sql->bind_param("?email", $recupera);
    $sql->execute();
    $result = $sql->get_result();

    if (($recupera->rowCount() != 0) and ($recupera)) {
        echo "foi";
    } else {
        echo "nao foi";
    }
}
?>

</html>