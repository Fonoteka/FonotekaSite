<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Fonotéka</title>
</head>

<body>
    <header>
        <a class="link_img" href="">
        <img class="img_logo" src="assets/Logo.png" />Fonoteka
        </a>

        <div class="opcoes_div">
        <a href=""> Home </a>
        <a href=""> Sobre nós </a>
        <a href=""> Aluno </a>
        <a href="./guia.php"> Guia </a>
        </div>

        <div class="div_usuario">
          <img id="perfil_usuario" class="img_perfil" src="assets/perfil-Icon.png" />
          <label for="perfil_usuario" class="perfil_label"><?php echo "Usuário"?></label>
        </div>

        <section class="popLogin">
            <label for="email">Email:</label>
            <input type="text" id="email" disabled>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" disabled>
            <button>Acessar</button>
        </section>
    </header>

    <h1>Seja bem-vindo</h1>
    <a href="./logout.php">Sair</a>
</body>

<script src="././js/popLogin.js"></script>

</html>