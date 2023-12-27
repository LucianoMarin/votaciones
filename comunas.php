<?php

/** vista select comuna
 *  esta lista se llena segun el valor
 *  enviado en el select region
 * 
 */



/**
 * SE LLAMAN LAS CLASES CONEXION
 * Y METODOS DENTRO DE CONTROLADORFORMULARIO
 */

include_once('../formulario/modelo/conexion.php');
include_once('../formulario/controlador/controladorformulario.php');
$comuna=new controladorformulario();
$valor=$comuna->selectcomuna();

?>


<!---
CON EL METODO SELECTCOMUNA, SE LLENA EL SELECT COMUNA
GRACIAS LA INFORMACION DE REGION ENVIADA AL METODO POR VIA DE AJAX. 
-->

<?php foreach($valor as $comunas){ ?>
<option value="<?php echo $comunas['id_comuna']?>"> <?php echo $comunas['nombre_comuna']?></option>
<?php }?>

