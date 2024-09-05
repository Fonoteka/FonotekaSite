<?php
function protectAdm($adm)
{
    if (empty($_SESSION['id'])) {
        header("Location: ../pages/index.php");
        echo ("<script>msgPop('É necessario login');</script>");
        exit();
    }

    $funcao = !empty($_SESSION['funcao']) ? $_SESSION['funcao'] : 0;

    if ($funcao == 0 and $adm) {
        header("Location: ../pages/index.php");
        exit();
    }
}

?>