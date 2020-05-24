<?php



date_default_timezone_set("America/Hermosillo");
//Standing LMB
function standings_lmb($zona,$temp){
	$url = "http://lookup-service-prod.bamgrid.com/json/named.standings_display_flip.bam?sit_code=%27h0%27&sit_code=%27h1%27&sit_code=%27h2%27&standings_all.col_ex=playoff_points_sw%2Cpoints%2Cstreak%2Celim%2Clast_ten%2Chome%2Caway%2Cvs_division%2Cis_wildcard_sw%2Cgb_wildcard%2Celim_wildcard&league_id=125&org_id=125&season=".$temp;
	$standings = json_decode(file_get_contents($url) , true);
	foreach($standings['standings_display_flip']['standings_all']['queryResults']['row'] as $standings) {
		if ($standings['division'] == $zona) {
			echo('
				
                <tr>
                    <td class="data-rank">'.$standings['place'].'</td>
                    <td class="data-name has-logo">
                        <a href="">
                            <span class="team-logo">
                                <img width="128" height="128" src="/50/'.$standings['file_code'].'.gif" class="attachment-sportspress-fit-icon size-sportspress-fit-icon wp-post-image" alt="'.$standings['team_short'].'">
                            </span>'.$standings['team_full'].'
                        </a>
                    </td>
                    <td class="data-w">'.$standings['w'].'</td>
                    <td class="data-l">'.$standings['l'].'</td>
                    <td class="data-pf">'.$standings['pct'].'</td>
                    <td class="data-pct">'.$standings['gb'].'</td>
                </tr>
			');
		}
	}
}

//Agenda deportiva
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

    $contador = "0";
    $data = json_decode(file_get_contents($url), true);
    $games = isset($data['data']['games']['game'][0]) ? $data['data']['games']['game'] : [$data['data']['games']['game']];
    foreach($games as $i) {
        if ($i['league'] == $torneo) {
            $contador = $contador+1;  
            $i['home_team_name'] = str_replace(' ', '-', $i['home_team_name']);
            $i['away_team_name'] = str_replace(' ', '-', $i['away_team_name']);

            if ($i['status']['status'] == "Preview" or $i['status']['status'] == "Warmup" or $i['status']['status'] == "Pre-Game") { $estado_juego = 'Pr&oacute;ximamente'; }
            if ($i['status']['status'] == "Postponed"){ $estado_juego = 'Pospuesto'; }
            if ($i['status']['status'] == "In Progress") { $estado_juego = 'En progreso'; }
            if ($i['status']['status'] == "Final") { $estado_juego = 'Terminado'; }
            $ocultar = ($i['status']['status'] == "In Progress")?'':'d-none';
            echo ('
                <div class="col-md-4 kard">
                    <table class="evento" width="100%">
                        <thead class="titulo_evento">
                            <tr>
                                <th> <img class="logo_equipo" src="equipos/'.$i['away_team_id'].'.svg" width="24" alt="'.$i['home_team_city'].'"> </th>
                                <th> '.$i['away_team_name'].' Vs. '.$i['home_team_name'].' </th>
                                <th> <img class="logo_equipo" src="equipos/'.$i['home_team_id'].'.svg" width="24" alt="'.$i['away_team_city'].'"> </th>
                            </tr>
                        </thead>
                    </table>
        
                    <table class="evento" width="100%">
                        <tbody>
                            <tr class="hora_evento">
                                <td colspan="2"> '.$i['home_time'].' '.$i['home_ampm'].' '.$i['home_time_zone'].'  @ '.$i['venue'].' </td>
                            </tr>
                            <tr class="estado_evento">
                                    <td colspan="2"> '.$estado_juego.' </td>
                            </tr>
                                <tr class="botones_evento '.$ocultar.' ">
                                    <td> <a href="play/'.$i['game_pk'].'/'.$i['home_sport_code'].'/'.$i['league'].'" class="btn btn-ver"> VISITA </a> </td>
                                    <td> <a href="play/'.$i['game_pk'].'/'.$i['home_sport_code'].'/'.$i['league'].'" class="btn btn-ver"> CASA </a> </td>
                                </tr>
                        </tbody>
                    </table>
        
                </div>
            ');
        }
    }
}

//Marcadores
function marcadores($liga,$torneo,$pk){
    
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

    $contador = "0";
    $data = json_decode(file_get_contents($url), true);
    $games = isset($data['data']['games']['game'][0]) ? $data['data']['games']['game'] : [$data['data']['games']['game']];
	foreach($games as  $i) {
	    
		if ($i['league'] == $torneo ) {

		    $contador = $contador+1;  
			$i['home_team_name'] = str_replace(' ', '-', $i['home_team_name']);
            $i['away_team_name'] = str_replace(' ', '-', $i['away_team_name']);
            
			if ($i['status']['status'] == "Preview" or $i['status']['status'] == "Warmup" or $i['status']['status'] == "Pre-Game") {
                $estado_juego = 'Pr&oacute;ximamente';
            }
			if($i['status']['status'] == "Postponed"){ $estado_juego = 'Pospuesto'; }
			if ($i['status']['status'] == "In Progress") { 
                $state  = ($i['status']['inning_state'] == 'Top')?'Alta':'Baja';
                $estado_juego = $i['status']['inning']." ".$state.' - En progreso'; 
            }
            if ($i['status']['status'] == "Final") { $estado_juego = 'Terminado'; }


            $selected = ($pk == $i['game_pk'])?'viendo':'';
            $r_home = ($i['linescore']['r']['home'] == '')?'0':$i['linescore']['r']['home'];
            $r_away = ($i['linescore']['r']['away'] == '')?'0':$i['linescore']['r']['away'];
            


            $host= $_SERVER["HTTP_HOST"];
            $url_web  = "http://" . $host ."/web";

            echo ('
                <div class="col-xs-3">
                    <a href="/web/play/'.$i['game_pk'].'/'.$liga.'/'.$torneo.'">
                        <div class="marcador '.$selected.'">
                            <h5> '.$estado_juego.' </h5>
                            <span><img class="logo_marcador" src="'.$url_web.'/equipos/'.$i['away_team_id'].'.svg" width="18" alt="'.$i['away_team_city'].'">  '.$i['away_name_abbrev'].' - '.$r_away.'</span><br>
                            <span><img class="logo_marcador" src="'.$url_web.'/equipos/'.$i['home_team_id'].'.svg" width="18" alt="'.$i['home_team_city'].'"> '.$i['home_name_abbrev'].' - '.$r_home.'</span>
                        </div>
                    </a>
                </div>
            ');


           

		}
	}
	   
}

//Cargar player Juegos LMP & LMB
function player_mex($stream,$div){
    if($stream == 'no' and $div == 'home'){
        echo " <script> alert('No hay señal para este partido. Disculpa las molestias'); window.location = '../../../'; </script> " ;
    }
    echo('
        <div id="'.$div.'"></div>
        <script>
            var playerElement = document.getElementById("'.$div.'");
            var player = new Clappr.Player({
                source: "'.$stream.'",
                poster: "http://clappr.io/poster.png",
                mute: true,
                autoPlay: false,
                width: "100%",
                height: "400px"
            });
            player.attachTo(playerElement);
        </script>
    ');
}

//Cargar player Juegos MLB
function player_mlb($pk,$stream){

    //Evaluamos fecha
    $date = date("m/d/Y");
    $fulldate = date("m/d/Y",strtotime($date));
    $fulldate = explode("/",$fulldate);
    $year = (!empty($fulldate[2]))?$fulldate[2]:date("Y");
    $month = (!empty($fulldate[0]))?$fulldate[0]:date("m");
    $day = (!empty($fulldate[1]))?$fulldate[1]:date("d");
    $date = "year_".$year."/month_".$month."/day_".$day;
    $url = "http://gd.mlb.com/components/game/mlb/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
	$juegohoy = json_decode(file_get_contents($url), true);
	foreach($juegohoy['data']['games']['game'] as $i) { 
        if($pk == $i['game_pk']){
            $i['home_team_name'] = str_replace(' ', '-', $i['home_team_name']);
            $i['away_team_name'] = str_replace(' ', '-', $i['away_team_name']);
            $stream = ($stream == 'home')? $i['home_team_name'] : $i['away_team_name'];
            $stream = strtolower($stream);

            if($stream == 'd-backs'){
                $stream  = 'diamondbacks';
            }
            if($stream == 'blue-jays'){
                $stream  = 'jays';
            }
            if($stream == 'red-sox'){
                $stream  = 'redsox';
            }
            if($stream == 'white-sox'){
                $stream  = 'whitesox';
            }

            echo ('
                <iframe src="http://#/mlb/'.$stream.'.php" width="100%" height="400" scrolling="no" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
            ');
        }
        
    }
    

    
}







