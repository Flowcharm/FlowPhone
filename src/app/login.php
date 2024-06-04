<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <?php include_once "../includes/common_head.php" ?>
</head>

<body>

    <div class="login">
        <h2>Iniciar sesión</h2>
        <form action="">
            <input type="text" placeholder="example@email.com">
            <input type="password" placeholder="Contraseña">
            <input type="submit" value="Iniciar sesión">
        </form>
        <button>Iniciar sesión con google</button>
        <a href="./forgot.php">¿Olvidaste tu contraseña?</a>
        <a href="./register.php">¿No tienes cuenta? ¡Regístrate!</a>
    </div>

</body>

</html>