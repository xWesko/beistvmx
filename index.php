<?php

    require_once 'funciones_milb.php';
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
        <link rel="stylesheet" href="reset.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="inicio.css">
        <title> Verbeisbol.com </title>
    </head>
    <body>

     

        <nav class="navbar navbar-expand-md navbar-dark header menu">
            
            <a class="navbar-brand" href="#">
                <img class="logo" src="img/logo.png" alt="logo">
            </a>
                        
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
                    
            <div class="collapse navbar-collapse justify-content-end"  id="menu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"> DMCA </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> CONTACTO </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link donaciones" href="#"> Donaciones </a>
                    </li> 
                </ul>
            </div>
            
        </nav>
    
        <div class="container-fluid vb">
            <div class="parallax_vb"></div>

            <div class="contenido">

                <div class="row">
                    <div class="col-md-12">
                        <div class="titulo">
                            <h2>Media Center</h2>
                        </div>
                        <p class="txt1"> ¿Necesitas ayuda ? Entra  <a href="#"> aqui </a> </p>
                    </div>
                </div>

                <div class="row">
                    <div class="scrim">
                        <h2>Agenda deportiva</h2>
                    </div>
                    <p class="txt2"> 
                        El partido comienza antes de 5 minutos. <br> Recuerda que los juegos son sin confirmar, es decir no siempre estaran disponibles. <br>
                        La hora de inicio corresponde a la hora del centro.
                    </p>
                </div>

                <div class="row">



                    <?php juegos('mlb','NN'); ?>
                    <?php juegos('mlb','NA'); ?>
                    <?php juegos('mlb','AA'); ?>
                    <?php juegos('mlb','AN'); ?>
                    <?php juegos('lmb','MEX'); ?>

                </div>

            </div>

            <footer  class="py-4">
                <div class="container text-center">
                    <small>Copyright <?php echo date('Y'); ?> &copy; verbeisbol.com</small>
                </div>
            </footer>
            
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>