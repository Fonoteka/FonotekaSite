<?php
include_once("../php/conexao.php");
include_once("../php/session.php");
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
            <input type="submit" value="Recuperar">
            <a href="/index.php">Lembrou?</a>
            <?php echo !empty($_SESSION['msg']) ? $_SESSION['msg'] : "" ?>
        </form>
    </main>
</body>

<?php
if (!empty($_POST['recupera'])) {
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
            $_SESSION['msg'] = "<a href=\"http://localhost/fonotekaSite/pages/recupSenha.php?chave=$chave_recupera_senha\">AQUI</a>";
        } else {
            echo "erro2";
        }
    } else {
        echo "erro1";
    }
}
?>

</html>