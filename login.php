<?php
    session_start();

    if(isset($_SESSION['valid'])){
        header("Location: /"); // Redirige a la página principal
        exit();
    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $valid_user = "admin";
        $valid_password = "Lauty12052003";
        
        $user = $_POST['user'];
        $password = $_POST['password'];

        if ($user == $valid_user &&  $password == $valid_password) {
            // Iniciar sesión
            $_SESSION['valid'] = 1;
            $_SESSION['user'] = $user;

            header("Location: /"); // Redirige a la página principal
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'components/head.php'; ?>
    <title>AutoDealer | Login</title>
</head>

<body>   

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; overflow:hidden">
        <form action="" method="post" style="max-width: 500px; width: 100%">
            <p class="text-center">
                <img src="assets/images/logo.png" width="150" alt="">
            </p>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Usuario</label>
                <input type="text" name="user" class="form-control" style="width: 100%">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" style="width: 100%">
            </div>
            <button type="submit" class="btn btn-primary mb-3">Ingresar</button>
        </form>
    </div>

</body>
</html>