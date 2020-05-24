<?php
date_default_timezone_set("America/Hermosillo");
    session_start();
    if(!isset($_SESSION['LOGUEADO'])){
        header('Location:index.php');
        
    }
    $user=$_SESSION['USUARIO'];

    $pk = $_GET['id'];

    if(isset($_POST['agregar'])){

      require_once 'db.php';
      require_once 'juegos.php';

      $obj = new Juegos();        
      $obj->guardar_juego($pk);
      echo '<script> alert("Se grego correctamente."); window.location = "editar.php?id='.$pk.'&liga='.$_GET['liga'].'&torneo='.$_GET['torneo'].'" </script>';	



    }


?>

<!doctype html>
<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Agregar</title>
  </head>

  <body>

  	<style type="text/css">
  		.contenido{
  			margin-right: auto;
  			margin-left: auto;
        text-transform: uppercase;
  		}
      .btn{
        text-transform: uppercase;
      }
  	</style>    

    <div class="container">
      <div class="col-sm-8 contenido">
        <h1>Panel de administracón</h1>

       	<h3>El Juego no esta agregado en la base de datos.</h3>
        
        	<form action="" method="post">
            	<input type="hidden" name="txtPk" value="<?php echo $pk ?>">
                <button type="submit" name="agregar" class="btn btn-info"> Agregar </button>
                <a href="panel.php" class="btn btn-success">Volver</a>
            </form>
      </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>

