<?php

    $pk = $_GET['pk'];
    $host= $_SERVER["HTTP_HOST"];
    $url_web  = "http://" . $host ."/web";
    require_once 'funciones_milb.php';
    require_once 'panel/db.php';
    require_once 'panel/juegos.php';

    $obj = new Juegos();
    $juego = $obj->obtener_id($pk);

    //Comprimir o minificar HTML
    function comprime_html($pagina) {
        $buscar = array(
            '/\>[^\S ]+/s',     // Eliminar espacios en blanco después de las etiquetas, excepto el espacio
            '/[^\S ]+\</s',     // Eliminar espacios en blanco antes de las etiquetas, excepto el espacio
            '/(\s)+/s',         // Acortar múltiples secuencias de espacios en blanco
            '/<!--(.|\s)*?-->/' // Eliminar comentarios HTML
        );
        $remplaza = array(
            '>',
            '<',
            '\\1',
            ''
        );
        $pagina = preg_replace($buscar, $remplaza, $pagina);
        return $pagina; 
    }
    ob_start("comprime_html");

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="Description" content="Ver beisbol en vivo y gratis.">
        <link rel="stylesheet" href="<?php echo $url_web; ?>/reset.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $url_web; ?>/play.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script> 
        <script type="text/javascript" src="https://cdn.jsdelivr.net/clappr.level-selector/latest/level-selector.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/clappr.chromecast-plugin/latest/clappr-chromecast-plugin.js"></script>

        <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

      
        <title> Juego </title>
    </head>
    <body>

        <div class="container">
                <div class="d-flex justify-content-center">
                    <img class="logo" src="<?php echo $url_web; ?>/img/logo.png" alt="logo">
                </div>            
        </div>
      
        
        <div class="container mt-5">

            <div class="row marcadores" id="marcadores">
                   
            </div>

            <div class="row canal">
                <div class="col-md-8">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"> OPCION 1 </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="visit-tab" data-toggle="tab" href="#visit" role="tab" aria-controls="visit" aria-selected="false"> OPCION 2 </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="embed-responsive embed-responsive-16by9">
                            <?php 
                                if($_GET['torneo'] == 'mlb'){
                                    player_mlb($_GET['pk'],'home');
                                }else{
                                    $stream = $juego[0]->stream_hd; 
                                    player_mex($stream,'home'); 
                                }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="visit" role="tabpanel" aria-labelledby="visit-tab">
                        <div class="embed-responsive embed-responsive-16by9">
                            <?php 
                                if($_GET['torneo'] == 'mlb'){
                                    player_mlb($_GET['pk'],'visit');
                                }else{
                                    $stream  = $juego[0]->stream_sd; 
                                    player_mex($stream,'visit'); 
                                }
                            ?>
                        </div>
                    </div>
                </div>

                

                    

                </div>

                <div class="col-md-4">
                      chat 
                </div>
            </div>

            <div class="row scoreboard mt-5">
            
                <div class="col-md-8">
                    <div class="table-responsive" id="pizarra"></div>
                </div>

                <div class="col-md-4 botones">
                    <a href="#" class="btn btn-outline-warning btn-block"> DONACIONES </a>
                    <a href="#" class="btn btn-outline-danger btn-block"> REGLAS </a>
                </div>
            </div>  
            
            <div class="row mt-5 mb-5" id="lineups">

            </div>


        </div>


        <script>
            $(document).ready(function(){
                $("#pizarra").load('<?php echo $url_web; ?>/pizarra.php?pk=<?php echo $_GET['pk']."&torneo=".$_GET['torneo']."&liga=".$_GET['liga'];?>');
                $("#marcadores").load('<?php echo $url_web; ?>/marcadores.php?pk=<?php echo $_GET['pk'] ?>');
                $("#lineups").load('<?php echo $url_web; ?>/lineups.php?pk=<?php echo $_GET['pk']."&torneo=".$_GET['torneo']; ?>');
                setInterval(function(){
                    $("#pizarra").load('<?php echo $url_web; ?>/pizarra.php?pk=<?php echo $_GET['pk']."&torneo=".$_GET['torneo']."&liga=".$_GET['liga'];?>'),
                    $("#marcadores").load('<?php echo $url_web; ?>/marcadores.php?pk=<?php echo $_GET['pk'] ?>'),
                    $("#lineups").load('<?php echo $url_web; ?>/lineups.php?pk=<?php echo $_GET['pk']."&torneo=".$_GET['torneo']; ?>')
                }, 90000);
            });
        </script>

        
      
 

     
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>