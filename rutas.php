<?php

class ruta
{
    /**
     * Clase donde se define los path de las rutas.
     * Se generara el path de los modelos, vistas, controladores.
     * 
     */


    static function rutas()
    {

        /**
         * PATH MODELOS 
         */

        define('conexion', '../formulario/modelo/conexion.php');
        define('votante', '../formulario/modelo/votante.php');




        /**
         * PATH CONTROLADORES
         */


        define('controladorformulario', '../formulario/controlador/controladorformulario.php');




        /**
         * PATH vistas
         */


        define('error', '../formulario/vistas/error/index.php');



        /**
         * PATH ASSETS
         */


        define('css', '/formulario/assets/css/estilo.css');
        define('js', '/formulario/assets/javascript/js.js');
        define('jquery', '/formulario/assets/javascript/jquery.js');
    }
}
