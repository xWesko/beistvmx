<?php
    session_start();
    if(isset($_SESSION['LOGUEADO'])){
        header("Location: panel.php");
    }
    include 'db.php';
    include 'usuarios.php';

    
    if(isset($_POST['entrar'])){
        $email = $_POST['txtUsuario'];
        $password = $_POST['txtPassword'];
        
        
        $usuario = new Usuarios();
        $obj = $usuario->login_usuario($email,$password);
    }
    
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Description" content="Ver beisbol en vivo y gratis.">
        <link rel="stylesheet" href="../reset.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title> Login </title>
    </head>

    <style>
    .logo{
        margin: 20px 0px;
        width: 100px;
    }
    </style>

    <body>

        <div class="container">
            <div class="d-flex justify-content-center">
                <img class="logo" src="../img/logo.png" alt="logo">
            </div> 
            
            
            <div class="row d-flex justify-content-center">

            
                <div class="col-md-4">

                    <?php  if(isset($_GET['e']) and $_GET['e'] == 1) {  ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>STRIKE!</strong> Datos incorrectos! 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php   }    ?>
            
                    <form action="" method="post">

                        <div class="form-group">
                            <label> Usuario: </label>
                            <input type="email" name="txtUsuario"  class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label> Contraseña: </label>
                            <input type="password" name="txtPassword" class="form-control" required>
                        </div>

                        <button type="submit" name="entrar" class="btn btn-info btn-xs btn-block">
                            Entrar
                        </button>

                    </form>

                </div>
            </div>
        </div>
      

        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>