<?php
if (!empty($_POST['email']) && !empty($_POST['senha'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $email = $conn->real_escape_string($_POST['email']);
    $senha = $conn->real_escape_string($_POST['senha']);

    $sql = $conn->prepare("SELECT * FROM tb_cadastro WHERE email=?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    $user = $result->fetch_assoc();

    if ($result->num_rows == 1) {

        if (password_verify($senha, $user['Senha'])) {

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $user['IdMentor'];
            $_SESSION['nome'] = $user['Nome'];

            $idImagem = $user['IdImagem'];
            $sql = $conn->query("SELECT path FROM tb_Imagens WHERE IdImagem = $idImagem");
            $path = $sql->fetch_all(MYSQLI_ASSOC);

            $_SESSION['path_img'] = $path[0]['path'];
            header("Location: ".$_SERVER['PHP_SELF']);
        } else {
            echo "<script>msg('SENHA INCORRETA!!')</script>";
        }

    } else {
        echo "<script>msg('EMAIL INCORRETO!!')</script>";
    }
}

?>