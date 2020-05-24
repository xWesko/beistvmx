<?php
    date_default_timezone_set("America/Hermosillo");
    session_start();
    if(!isset($_SESSION['LOGUEADO'])){
        header('Location:index.php');
        
    }
    $user=$_SESSION['USUARIO'];

    require_once 'db.php';
    require_once 'juegos.php';

    function editar($liga){

        $pk = $_GET['id'];
        $objJuegos = new Juegos();
        $juego = $objJuegos->obtener_id($pk);


        // Evaluate date
        $date = date("m/d/Y");
        $fulldate = date("m/d/Y",strtotime($date));
        $fulldate = explode("/",$fulldate);
        $year = (!empty($fulldate[2]))?$fulldate[2]:date("Y");
        $month = (!empty($fulldate[0]))?$fulldate[0]:date("m");
        $day = (!empty($fulldate[1]))?$fulldate[1]:date("d");
        $date = "year_".$year."/month_".$month."/day_".$day;
        

        if($liga == 'mlb'){
			$url = "http://gd.mlb.com/components/game/mlb/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
		}
		if($liga == 'lmb'){
			$url = "http://gd.mlb.com/components/game/aaa/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
		}
		if($liga == 'lmp'){
			$url = "http://gd.mlb.com/components/game/win/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
        }

        
        $contador = "0";
        $data = json_decode(file_get_contents($url), true);
        $games = isset($data['data']['games']['game'][0]) ? $data['data']['games']['game'] : [$data['data']['games']['game']];
        foreach($games as $game) {
        $contador = $contador+1;   
        $game['home_team_name'] = str_replace(' ', '-', $game['home_team_name']);
        $game['away_team_name'] = str_replace(' ', '-', $game['away_team_name']);

            if(!isset($juego[0]->pk)){
               header("location:agregar.php?id=".$pk."&liga=".$_GET['liga']."&torneo=".$_GET['torneo']);
            }

            if($pk == $game['game_pk']){
              echo (' 
              
                <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <td> <img width="30" src="http://www.milb.com/shared/images/logos/50x50/t'.$game['away_team_id'].'.png">
                       '.$game['away_name_abbrev'].' </td>

                        <td>'.$game['home_name_abbrev'].' <img width="30" src="http://www.milb.com/shared/images/logos/50x50/t'.$game['home_team_id'].'.png">
                        </td>
                        <td>'.$game['game_pk'].'</td>
                      </tr>
                    </table>
                </div>

                <form action=""  method="post">
                    <input type="hidden" name="txtpk" value="'.$juego[0]->pk.'">

                    <div class="form-group">
                        <label>SD:</label>
                        <textarea style="height:230px" name="txtcodigo" class="form-control">'.$juego[0]->stream_sd.'</textarea>
                    </div> 
                  
                    <div class="form-group">
                        <label>HD:</label>
                        <textarea style="height:230px" name="txtcodigo_hd" class="form-control">'.$juego[0]->stream_hd.'</textarea>
                    </div> 

                    <button type="submit" name="editar" class="btn btn-info">Guardar cambios</button>
                    <a href="panel.php" class="btn btn-success">Volver</a>
                </form>

              ');

            } 


            
        //}
      }
        
    }


    if(isset($_POST['editar'])){
   
        $obj = new Juegos();
        $pk = $_POST['txtpk'];
        $stream = $_POST['txtcodigo'];
        $stream_hd = $_POST['txtcodigo_hd'];
        $obj->actualizar($stream,$stream_hd,$pk);

    
        echo '<script> alert("Se grego correctamente."); window.location = "editar.php?id='.$pk.'&liga='.$_GET['liga'].'&torneo='.$_GET['torneo'].'" </script>';	
    }




?>

<!doctype html>
<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Editar: <?php echo $_GET['id']; ?> </title>
  </head>

  <body>



  	<style type="text/css">
  		.contenido{
  			margin-right: auto;
  			margin-left: auto;
  		}
  		label{
  		    font-weight: bold;
  		}
  		.separador{
  		    width:100%;
  		    margin: 20px 0px;
  		}
  	</style>

    

    <div class="container">
      <div class="col-sm-10 contenido">
        <h1>Panel de administracón</h1>


            
            <?php  editar($_GET['liga'],$_GET['torneo']); ?>
          
          <div class="separador"></div>
      

      </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>