<?php
	date_default_timezone_set("America/Hermosillo");
    session_start();
    if(!isset($_SESSION['LOGUEADO'])){
        header('Location:index.php'); 
    }
    $user = $_SESSION['USUARIO'];

    require_once 'db.php';
    require_once 'juegos.php';
   
   	$objJuegos = new Juegos();
    $juegos = $objJuegos->listar_juegos();



	function juegos($liga,$torneo){
    
		//Evaluamos fecha
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
	
		$ocultar = ($liga == '')?'d-none':'';
		
		$contador = "0";
		$data = json_decode(file_get_contents($url), true);
		$games = isset($data['data']['games']['game'][0]) ? $data['data']['games']['game'] : [$data['data']['games']['game']];
		foreach($games as $i) {
			if ($i['league'] == $torneo ) {
	
				$contador = $contador+1;  
				$i['home_team_name'] = str_replace(' ', '-', $i['home_team_name']);
				$i['away_team_name'] = str_replace(' ', '-', $i['away_team_name']);
				echo ('
					<tr>
	        			<td>
	        				<img width="30" src="http://www.milb.com/shared/images/logos/50x50/t'.$i['away_team_id'].'.png">
	        					 '.$i['away_name_abbrev'].' 
	        			</td>
	        			<td>
	        				'.$i['home_name_abbrev'].'
	        				<img width="30" src="http://www.milb.com/shared/images/logos/50x50/t'.$i['home_team_id'].'.png">	
	        			</td>
						<td>'.$i['game_pk'].'</td>
						<td>'.$i['status']['status'].'</td>
	        			<td><a class="btn btn-success '.$ocultar.'" href="editar.php?id='.$i['game_pk'].'&liga='.$liga.'&torneo='.$torneo.'"> EDITAR</a></td>
	        			<td><a class="btn btn-info" href="agregar_foto.php?id='.$i['game_pk'].'"> AGREGAR</a></td>
	        		</tr>
				');
	
			}
		}
		$contador = ($contador == 0)?'<b>No hay juegos de: </b> ' .$liga. '-'.$torneo.'<br>' :'';
		echo('
			<div class="col-md-12 contador d-flex justify-content-center">
				'.strtoupper($contador).'
			</div>
		');
		
		   
	}

?>

<!doctype html>
<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Panel</title>
  </head>

  <body>

  	<style type="text/css">
  		.contenido{
  			margin-right: auto;
  			margin-left: auto;
		}
		.contador{
			margin: 4px 0px;
		}
		  
  	</style>

    

    <div class="container">
      <div class="col-sm-8 contenido">


        <div class="table-responsive">
        	<table class="table table-striped">
        		<thead class="thead-dark"> 
        			<tr>
        				<td scope="col">Visita</td>
        				<td>Casa</td>
        				<td>PK</td>
						<td> Status </td>
        				<td>Editar</td>
        				<td>Agregar Foto</td>
        			</tr>
        		</thead>
        		<tbody>
					<?php juegos('mlb','NN'); ?>
                    <?php juegos('mlb','NA'); ?>
                    <?php juegos('mlb','AA'); ?>
                    <?php juegos('mlb','AN'); ?>
					<?php juegos('lmb','MEX'); ?>
					<?php //juegos('lmp','MEX'); ?>
        		</tbody>
        	</table>
        </div>

        <br>

        <a href="salir.php" class="btn btn-warning">Cerrar sesion</a>
      

      </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>