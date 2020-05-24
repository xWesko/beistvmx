<?php


date_default_timezone_set("America/Hermosillo");



function obtener_gid(){
    //Evaluamos fecha
    $date = date("m/d/Y");
    $fulldate = date("m/d/Y",strtotime($date));
    $fulldate = explode("/",$fulldate);
    $year = (!empty($fulldate[2]))?$fulldate[2]:date("Y");
    $month = (!empty($fulldate[0]))?$fulldate[0]:date("m");
    $day = (!empty($fulldate[1]))?$fulldate[1]:date("d");
    $date = "year_".$year."/month_".$month."/day_".$day;
    
    if($_GET['torneo'] == 'mlb'){
        $url = "http://gd.mlb.com/components/game/mlb/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
    }
    if($_GET['torneo'] == 'lmb'){
        $url = "http://gd.mlb.com/components/game/aaa/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
    }
    if($_GET['torneo'] == 'lmp'){
        $url = "http://gd.mlb.com/components/game/win/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
    }
    

    $data = json_decode(file_get_contents($url), true);
    $games = isset($data['data']['games']['game'][0]) ? $data['data']['games']['game'] : [$data['data']['games']['game']];
    foreach($games as $i) {
        if ($i['game_pk'] == $_GET['pk']) {
            $gid = "year_".$year."/month_".$month."/day_".$day."/gid_".$i['gameday'];
        }
    }
    return $gid;
}

function obtener_entrada(){
    //Evaluamos fecha
    $date = date("m/d/Y");
    $fulldate = date("m/d/Y",strtotime($date));
    $fulldate = explode("/",$fulldate);
    $year = (!empty($fulldate[2]))?$fulldate[2]:date("Y");
    $month = (!empty($fulldate[0]))?$fulldate[0]:date("m");
    $day = (!empty($fulldate[1]))?$fulldate[1]:date("d");
    $date = "year_".$year."/month_".$month."/day_".$day;
    
    if($_GET['torneo'] == 'mlb'){
        $url = "http://gd.mlb.com/components/game/mlb/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
    }
    if($_GET['torneo'] == 'lmb'){
        $url = "http://gd.mlb.com/components/game/aaa/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
    }
    if($_GET['torneo'] == 'lmp'){
        $url = "http://gd.mlb.com/components/game/win/year_".$year."/month_".$month."/day_".$day."/master_scoreboard.json";
    }

    $data = json_decode(file_get_contents($url), true);
    $games = isset($data['data']['games']['game'][0]) ? $data['data']['games']['game'] : [$data['data']['games']['game']];
    foreach($games as $i) {
        if ($i['game_pk'] == $_GET['pk']) {
            $i['home_team_name'] = str_replace(' ', '-', $i['home_team_name']);
			$i['away_team_name'] = str_replace(' ', '-', $i['away_team_name']);
			
			if ($i['status']['status'] == "Preview" or $i['status']['status'] == "Warmup" or $i['status']['status'] == "Pre-Game") {
                $estado_juego = 'Pr&oacute;ximamente';
            }
			if($i['status']['status'] == "Postponed"){ $estado_juego = 'Pospuesto'; }
			if ($i['status']['status'] == "In Progress") { $estado_juego = 'En progreso'; }
            if ($i['status']['status'] == "Final") { $estado_juego = 'Terminado'; }

            $inning_state = ($i['status']['inning_state'] == 'Top')?'Alta':'Baja';
            $inning = ($i['status']['inning'] == '')? $estado_juego : $i['status']['inning']." - ".$inning_state;            
        }
    }
    return $inning;
}


$gid = obtener_gid();

$entrada = obtener_entrada();


function bs_pizarra($gid,$entrada){


    if($_GET['torneo'] == 'mlb'){
     $url = "http://gd.mlb.com/components/game/mlb/".$gid."/boxscore.json";
    }
    if($_GET['torneo'] == 'lmb'){
        $url = "http://gd.mlb.com/components/game/aaa/".$gid."/boxscore.json";
    }
    if($_GET['torneo'] == 'lmp'){
        $url = "http://gd.mlb.com/components/game/win/".$gid."/boxscore.json";
    }


    $lin = json_decode(file_get_contents($url), true);
    echo('
        
        <table class="table table_sb">
            <thead>
                <tr class="entradas_sb">
                    <th> '.$entrada.'  </th>
                    ');foreach($lin['data']['boxscore']['linescore']['inning_line_score'] as $i) { echo('
                    <th class="inning">'.$i['inning'].'</th>
                    ');} echo('
                    <th class="separador"></th>
                    <th>C</th>
                    <th>H</th>
                    <th>E</th>
                </tr>
            </thead>
            <tbody>
                <tr class="equipo_sb">
                    <td> 
                        <img src="/web/equipos/'.$lin['data']['boxscore']['away_id'].'.svg" alt="visita" width="30"> '. 
                        strtoupper($lin['data']['boxscore']['away_team_code']).' 
                        <span style="font-size:11px;">('.$lin['data']['boxscore']['away_wins'].' - '.$lin['data']['boxscore']['away_loss'].')</span>
                    </td>
                    ');foreach($lin['data']['boxscore']['linescore']['inning_line_score'] as $i) { echo('
                    <td class="inning">'.$i['away'].'</td>
                    ');} echo('
                    <td class="separador"></td>
                    <td>'.$lin['data']['boxscore']['linescore']['away_team_runs'].'</td>
                    <td>'.$lin['data']['boxscore']['linescore']['away_team_hits'].'</td>
                    <td>'.$lin['data']['boxscore']['linescore']['away_team_errors'].'</td>
                </tr>
                <tr class="equipo_sb">
                    <td>
                        <img src="/web/equipos/'.$lin['data']['boxscore']['home_id'].'.svg" alt="casa" width="30"> '. 
                        strtoupper($lin['data']['boxscore']['home_team_code']).'
                        <span style="font-size:11px;">('.$lin['data']['boxscore']['home_wins'].' - '.$lin['data']['boxscore']['home_loss'].')</span>
                    </td>
                    ');foreach($lin['data']['boxscore']['linescore']['inning_line_score'] as $i) { echo('
                    <td class="inning">'.$i['home'].'</td>
                    ');} echo('
                    <td class="separador"></td>
                    <td>'.$lin['data']['boxscore']['linescore']['home_team_runs'].'</td>
                    <td>'.$lin['data']['boxscore']['linescore']['home_team_hits'].'</td>
                    <td>'.$lin['data']['boxscore']['linescore']['home_team_errors'].'</td>
                </tr>
            </tbody>
        </table>
       
    ');
}

bs_pizarra($gid,$entrada);




?>

