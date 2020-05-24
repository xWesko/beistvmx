<?php
date_default_timezone_set("America/Hermosillo");
    session_start();
    if(!isset($_SESSION['LOGUEADO'])){
        header('Location:index.php');
        
    }
    $user=$_SESSION['USUARIO'];

    $pk = $_GET['id'];

?>

<!doctype html>
<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Agregar foto</title>
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
        <h1>Panel de administrac&oacute;n</h1>
        
            <form action="banners/enviar.php" method="post">
                
                <input type="hidden" name="liga" value="lmp">
                <input type="hidden" name="txtpk" value="<?php echo $_GET['id']; ?>">
                        
                <div class="form-group">
                    <div class="nombre">
                        <input type="text" name="hora" class="form-control" placeholder="EN VIVO" value="EN VIVO" required>
                    </div>
                    
                    <div class="responsive-table">
                        <table class="table">
                            <tr>
                                <td colspan="3">Equipos</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select name="visita" class="form-control" required>
                                            <option value="mexico">Mexico</option>
                                            <option value="venezuela">Venezuela</option>
                                            
                                            <option value="rep. dominicana">Rep. Dominicana</option>
                                            <option value="panama">Panama</option>   
                                            <option value="cuba">Cuba</option> 
                                            <option value="puerto rico">Puerto Rico</option> 
                                        </select>
                                    </div>
                                </td>
                                <td>&#x26A1; </td>
                                <td>
                                    <div class="form-group">
                                        <select name="casa" class="form-control" required>
                                            <option value="mexico">Mexico</option>
                                            <option value="venezuela">Venezuela</option>
                                            
                                            <option value="rep. dominicana">Rep. Dominicana</option>
                                            <option value="panama">Panama</option>   
                                            <option value="cuba">Cuba</option> 
                                            <option value="puerto rico">Puerto Rico</option> 
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
                        
                <button type="submit" name="enviar" class="btn btn-primary">Generar Imagen</button>

                <a href="panel.php" class="btn btn-danger">Volver</a>
            </form>

        
      </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>

