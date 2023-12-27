<?php
/*

error_reporting(E_ALL);
ini_set('display_errors', '1');

SOLO QUITAR EL COMENTARIO SI DESEAS VER EN DONDE SE GENERO UN ERROR.

*/


/**
 * VISTA PRINCIPAL DEL FORMULARIO
 * 
 * 
 */



 /**
 * LLAMADO DE LAS RUTAS
 * 
 * 
 */



$url = $_SERVER['DOCUMENT_ROOT'] . '/formulario/rutas.php';
include_once($url);
ruta::rutas();

include_once(controladorformulario);
include_once(votante);



/**
 * LLAMADO DE METODOS DE CONTROLADORFORMULARIO
 * 
 * 
 */


$metodos = new controladorformulario();


/**
 * INSTANCIANDO METODOS
 * SE ALMACENA EL RESULTADO DEL METODO EN UNA VARIABLE, POR COMODIDAD.
 * 
 * $region hara un select from de la tabla region.
 * $candidato hara un select from de la tabla candidato.
 * $cantidadVoto con un contador sumara las instancias dentro de la tabla votantes
 * $ultimoVotante select from de votantes, retornara solo el ultimo rut ingresado.
 * $validarRut permite validar posteriormente con la ayuda de un boleano si el rut ya esta registrado en la BD.
 * 
 */



$region = $metodos->mostrarRegiones();
$candidato = $metodos->mostrarCandidatos();
$cantidadVotos = $metodos->contadorVotos();
$ultimoVotante = $metodos->ultimoVotante();
$validarRut = $metodos->validarRut();

$votante = new votante();


$encontrado = 0;

/**
 * 
 * CUANDO SE HAGA CLICK EN BOTON VOTAR HARA LO SIGUIENTE...
 * VALIDA PRIMERO EL RUT, EN CASO DE EXISTIR UN BOLEANO QUEDA CON VALOR 1
 * 
 * SIGUIENTE VALIDACION SI EL BOLEANO QUEDO CON VALOR 1 NO SE INGRESARA NADA,
 * DE LO CONTRARIO SI ES 0 CREARA UN OBJETO VOTANTE, LUEGO LLAMARA LA FUNCION 
 * QUE INSERTARA UNA NUEVA FILA DENTRO DE LA TABLA VOTANTE. FINALMENTE 
 * REDIRECCIONARA AL INDEX, Y ACTUALIZARA LAS TARJETAS DE NUMERO DE INGRESO
 * Y ULTIMO RUT REGISTRADO.
 * IMPORTANTE! COMO LOS CHECKBOX SON VARIOS VALORES, SE ALMACENARA EN LA TABLA COMO
 * UN TIPO JSON.
 * 
 * 
 * EN CASO DE GENERAR UN CONFLICTO EN LA BASE DE DATOS, TAMBIEN SE VALIDA DENTRO DEL CONTROLADOR
 * LAS EXCEPCIONES EN LA BD, LO CUAL NO DEBERIA PRESENTAR ERROR ALGUNO.
 * 
 */

if ($_POST) {

    foreach ($validarRut as $rut) {

        if ($_POST['rut'].$_POST['verificador'] == $rut['rut']) {
          $encontrado=1;

        }
        
    }



    if ($encontrado == 0) {


        $votante->setnombreCompleto($_POST['nombreCompleto']);
        $votante->setAlias($_POST['alias']);
        $votante->setRut($_POST['rut'] . $_POST['verificador']);
        $votante->setEmail($_POST['email']);
        $votante->setRegion($_POST['nro_region']);
        $votante->setComuna($_POST['comuna']);
        $votante->setCandidato($_POST['r_candidato']);

        $check = $_POST['copcion'];

        $jsoncheked = json_encode($check);

        $metodos->insertarVoto($votante, $jsoncheked);


    
        $msj="VOTO GENERADO EXITOSAMENTE!";

    
        header('Location: index.php');

      
    }
    else if( $encontrado == 1){

        echo "USUARIO: SEGUN NUESTRO REGISTROS SU RUT YA HA GENERADO UN VOTO";
    }
    
}


?>


<!--
PLANTILLA DEL FORMULARIO
DENTRO DE ESTA PLANTILLA HTML SE VERA LA ESTRUCTURA DEL FORMULARIO
COMO TAMBIEN SE PRECARGARA POR MEDIO DE PHP LOS VALORES DE LOS SELECT, EN 
ESTE CASO EN CANDIDATO,REGION Y COMUNA, SIENDO ESTA ULTIMA ASOCIADA A REGION POR MEDIO DE AJAX.
-->

<!DOCTYPE html>
<html lang="ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de votacion</title>
    <link href="<?php echo css ?> " rel="stylesheet">
</head>

<body>
    <div class="contenedor">
        <div class="elementof1">

            <label class="titulos">FORMULARIO DE VOTACION: </label>
            <br>
            <br>

            <form action="" method="POST" name="formulario">
                <div class="esForm">
                    <label>Nombre Apellido </label>
                    <input class="estiloInput" type="text" name="nombreCompleto" placeholder="Nombre y apellido">

                    <br>
                    <label>Alias </label>
                    <input class="estiloInput" type="text" name="alias" placeholder="Alias">


                    <div class="rut">
                        <label>Rut </label>
                        <input class="estiloInput" type="text" id="rut" name="rut" placeholder="Rut"> -
                        <input class="verificador" type="text" name="verificador" placeholder="" readonly>
                        <br>
                    </div>
                    <br>
                    <label>Email </label>
                    <input class="estiloInput" type="email" name="email" placeholder="Email">

                    <br>


                    <label>Region</label>
                    <select name="nro_region" class="selectEstilo">
                        <?php
                        foreach ($region as $regiones) { ?>
                            <option value="<?php echo $regiones['nro_region'] ?>" class="reg"><?php echo $regiones['prefijo'] . "-" . $regiones['nombre_region'] ?></option>
                        <?php
                        } ?>
                    </select>


                    <label>Comuna </label>
                    <select name="comuna" id="comuna" class="selectEstilo">


                        <option value="" class="reg"></option>

                    </select>


                    <label>Candidato </label>
                    <select name="r_candidato" class="selectEstilo">
                        <?php foreach ($candidato as $candidatos) { ?>
                            <option value="<?php echo $candidatos['rut_candidato'] ?>" class="reg"><?php echo $candidatos['nombre_candidato'] ?></option>
                        <?php
                        } ?>
                    </select>
                    <br>
                </div>
                <div class="esCheck">
                    <label><b>Como se entero con nosotros: </b></label>
                    <br>
                    <label>Web</label>
                    <input class="coption" name="copcion[]" value="web" type="checkbox">
                    <label>TV</label>
                    <input class="coption" name="copcion[]" value="tv" type="checkbox">
                    <label>Redes Sociales</label>
                    <input class="coption" name="copcion[]" value="redes sociales" type="checkbox">
                    <label>Amigos</label>
                    <input class="coption" name="copcion[]" value="amigos" type="checkbox">

                </div>
                <br>
                <br>

                <div id="mensaje"></div>
                <br>
                <br>
                <input id="inputVotar" type="submit" value="Votar">
            </form>
        </div>


        <div class="elementof2">

            <div class="elem2-2">
                VOTOS GENERADOS
                <br>
                <label class="tarjeta"><?php
                                        echo !empty($cantidadVotos) ? $cantidadVotos : "NO HAY VOTOS";

                                        ?></label>
            </div>


            <div class="elem2-3">
                ULTIMO RUT REGISTRADO
                <br>
                <label class="tarjeta"> <?php
                                        echo !empty($ultimoVotante) ? $ultimoVotante : "VOTANTE NO REGISTRADO";
                                        ?></label>

            </div>
        </div>


    </div>


    <script src="<?php echo jquery ?>"></script>
    <script src="<?php echo js ?>"></script>


    <script>


    </script>
</body>

</html>