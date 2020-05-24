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

$gid = obtener_gid();

//Bateadores
function bat_pizarra($gid,$team){
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
    
    //Mostramos los bateadores de visita
    if($team == 'visita'){
        //Bateadores Visita
        echo('
            <div class="table-responsive">
                <table class="table" style="color:#fff;">
                    <thead><tr><th colspan="12" style="background: #202020;padding: 1px 16px;">Bateadores '.$lin['data']['boxscore']['away_fname'].'</th></tr></thead>
                    <tbody>
                        <tr class="hed" style="background: #363636;">
                            <td class="player_name"></td>
                            <td class="position_cell">Pos</td><td>AB</td><td>R</td><td>H</td><td>2B</td><td>3B</td><td>HR</td><td>RBI</td><td>BB</td><td>SO</td><td>AVG*</td>
                        </tr>
                        '); foreach($lin['data']['boxscore']['batting']['1']['batter'] as $i) { if($i['pos'] !== "P"){ echo('
                        <tr>
                            <td class="player_name">
                                <a class="box_link" target="_blank" href="http://www.milb.com/player/index.jsp?sid=milb&player_id='.$i['id'].'"> '.$i['name_display_first_last'].' </a>
                            </td><td class="position_cell">'.$i['pos'].'</td><td>'.$i['ab'].'</td><td>'.$i['r'].'</td><td>'.$i['h'].'</td><td>'.$i['d'].'</td>	
                            <td>'.$i['t'].'</td><td>'.$i['hr'].'</td><td>'.$i['rbi'].'</td><td>'.$i['bb'].'</td><td>'.$i['so'].'</td><td>'.$i['avg'].'</td>
                        </tr>
                        '); }} echo('
                        <tr>
                            <td colspan="2" class="totals_row">		Total	</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['ab'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['r'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['h'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['d'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['t'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['hr'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['rbi'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['bb'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['so'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['1']['avg'].'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="info_bateadores">
            '.$lin['data']['boxscore']['batting']['1']['text_data_es'].'
            </div>
        ');
    }
    
    //Mostramos los bateadores de casa
    if($team == 'casa'){
        //Bateadores Casa
        echo('
            <div class="table-responsive">
                <table class="table" style="color:#fff;">
                    <thead><tr><th colspan="12" style="background: #202020;padding: 1px 16px;">Bateadores '.$lin['data']['boxscore']['home_fname'].'</th></tr></thead>
                    <tbody>
                        <tr class="hed" style="background: #363636;">
                            <td class="player_name"></td>
                            <td class="position_cell">Pos</td><td>AB</td><td>R</td><td>H</td><td>2B</td><td>3B</td><td>HR</td><td>RBI</td><td>BB</td><td>SO</td><td>AVG*</td>
                        </tr>
                        '); foreach($lin['data']['boxscore']['batting']['0']['batter'] as $i) { if($i['pos'] !== "P"){ echo('
                        <tr>
                            <td class="player_name">
                                <a class="box_link" target="_blank" href="http://www.milb.com/player/index.jsp?sid=milb&player_id='.$i['id'].'"> '.$i['name_display_first_last'].' </a>
                            </td><td class="position_cell">'.$i['pos'].'</td><td>'.$i['ab'].'</td><td>'.$i['r'].'</td><td>'.$i['h'].'</td><td>'.$i['d'].'</td>	
                            <td>'.$i['t'].'</td><td>'.$i['hr'].'</td><td>'.$i['rbi'].'</td><td>'.$i['bb'].'</td><td>'.$i['so'].'</td><td>'.$i['avg'].'</td>
                        </tr>
                        '); }} echo('
                        <tr>
                            <td colspan="2" class="totals_row">		Total	</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['ab'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['r'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['h'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['d'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['t'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['hr'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['rbi'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['bb'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['so'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['batting']['0']['avg'].'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="info_bateadores">
            '.$lin['data']['boxscore']['batting']['0']['text_data_es'].'
            </div>
        ');
    }
}
    

//Lanzadores
function pit_pizarra($gid,$team){
        
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
    
    //Mostramos los lanzadores de visita
    if($team == 'visita'){
        echo('
            <div class="table-responsive">
                <table class="table" style="color:#fff;">
                    <thead><tr><th colspan="12" style="background: #202020;padding: 1px 16px;">Lanzadores '.$lin['data']['boxscore']['away_fname'].'</th></tr></thead>
                    <tbody>
                        <tr class="hed" style="background: #363636;">
                            <td class="player_name"></td>
                            <td>IP</td><td>H</td><td>R</td><td>ER</td><td>BB</td><td>SO</td><td>HR</td><td>ERA*</td>
                        </tr>
                        '); foreach($lin['data']['boxscore']['pitching']['0']['pitcher'] as $i) { if($i['pos'] == "P"){  if(isset($i['note'])) { $n = $i['note']; }else{ $n = ""; }  echo ('
                        <tr>
                            <td class="player_name">
                                <a class="box_link" target="_blank" href="http://www.milb.com/player/index.jsp?sid=milb&player_id='.$i['id'].'"> '.$i['name_display_first_last'].' </a>  '.$n.'
                            </td>
                            <td>'.round($i['out']/3, 1, PHP_ROUND_HALF_ODD).'</td>
                            <td>'.$i['h'].'</td><td>'.$i['r'].'</td><td>'.$i['er'].'</td><td>'.$i['bb'].'</td><td>'.$i['so'].'</td><td>'.$i['hr'].'</td><td>'.$i['era'].'</td>
                        </tr>
                        '); }} echo('
                    
                        <tr>
                            <td class="totals_row">Total</td>
                            <td class="totals_cell">'.round($lin['data']['boxscore']['pitching']['0']['out']/3, 1, PHP_ROUND_HALF_ODD).'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['0']['h'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['0']['r'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['0']['er'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['0']['bb'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['0']['so'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['0']['hr'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['0']['era'].'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ');
    }
    
    
    //Mostramos los lanzadores de casa
    if($team == 'casa'){
       echo('
            <div class="table-responsive">
                <table class="table" style="color:#fff;">
                    <thead><tr><th colspan="12" style="background: #202020;padding: 1px 16px;">Lanzadores '.$lin['data']['boxscore']['home_fname'].'</th></tr></thead>
                    <tbody>
                        <tr class="hed" style="background: #363636;">
                            <td class="player_name" style="color:#fff"> </td>
                            <td>IP</td><td>H</td><td>R</td><td>ER</td><td>BB</td><td>SO</td><td>HR</td><td>ERA*</td>
                        </tr>
                        '); foreach($lin['data']['boxscore']['pitching']['1']['pitcher'] as $i) { if($i['pos'] == "P"){  if(isset($i['note'])) { $n = $i['note']; }else{ $n = ""; }  echo ('
                        <tr>
                            <td class="player_name">
                                <a class="box_link" target="_blank" href="http://www.milb.com/player/index.jsp?sid=milb&player_id='.$i['id'].'"> '.$i['name_display_first_last'].' </a>  '.$n.'
                            </td>
                            <td>'.round($i['out']/3, 1, PHP_ROUND_HALF_ODD).'</td>
                            <td>'.$i['h'].'</td><td>'.$i['r'].'</td><td>'.$i['er'].'</td><td>'.$i['bb'].'</td><td>'.$i['so'].'</td><td>'.$i['hr'].'</td><td>'.$i['era'].'</td>
                        </tr>
                        '); }} echo('
                    
                        <tr>
                            <td class="totals_row">Total</td>
                            <td class="totals_cell">'.round($lin['data']['boxscore']['pitching']['1']['out']/3, 1, PHP_ROUND_HALF_ODD).'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['1']['h'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['1']['r'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['1']['er'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['1']['bb'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['1']['so'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['1']['hr'].'</td>
                            <td class="totals_cell">'.$lin['data']['boxscore']['pitching']['1']['era'].'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        '); 
    }

    
}

?>


<div class="col-md-6">
<?php bat_pizarra($gid,'visita') ?>
</div>

<div class="col-md-6">
<?php bat_pizarra($gid,'casa') ?>
</div>

<div class="col-md-6">
<?php pit_pizarra($gid,'visita') ?>
</div>

<div class="col-md-6">
<?php pit_pizarra($gid,'casa') ?>
</div>