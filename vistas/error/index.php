<?php

/** 
 *  Vista para mostrar un error al usuario.
 * 
 * 
 * $url @String
 * url sera la variable que almacenara el path de root del servidor
 * mas la concatenacion del path donde esta el archivo que carga
 * las rutas.
 * 
 * ruta::rutas(); 
 * Es el metodo estatico para llamar todas las rutas necesarias.
 * 
 */



/**
 * SE LLAMA EL ARCHIVO QUE MANEJA LAS RUTAS
 * 
 */

$url = $_SERVER['DOCUMENT_ROOT'] . '/formulario/rutas.php';
include_once($url);
ruta::rutas();





?>


<!DOCTYPE html>
<html lang="ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR</title>
    <link href="<?php echo css ?>" rel="stylesheet">
</head>

<body>
    <div class="contenedor">
        <div class="fila">
            <div class="elemento1">
                <label class="titulosE">UPS! ENCONTRAMOS UN ERROR</label>
                <br>
                <br>
                <div id="ierror"> </div>
                <br>
                <label class="fontE">Error del <b>SISTEMA</b></label>
                <br>
                <label class="fontE">MENSAJE : No es posible tener conexion con la BD</label>
            </div>
        </div>
    </div>

</body>

</html>