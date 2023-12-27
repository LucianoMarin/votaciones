<?php

/**
 * Controladorformulario, aqui estaran todas las funciones
 * definidas para la vista y el modelo de Formulario
 * 
 */


$url = $_SERVER['DOCUMENT_ROOT'] . '/formulario/rutas.php';


include_once('../formulario/modelo/conexion.php');



class controladorformulario
{


    /**
     * Funcion muestra las regiones
     * almacenadas en la tabla region
     * retorna el arreglo de regiones
     */

    function mostrarRegiones()
    {
        $conexion = new conexion();
        $sql = "SELECT * FROM regiones";
        $resultado = $conexion->crearConexion()->prepare($sql);
        $resultado->execute();


        return $resultado->fetchAll();
    }






    /**
     * 
     * Funcion muestra las comunas
     * almacenadas en la tabla comunas
     * retorna el arreglo de comunas
     * 
     */


    function mostrarComunas()
    {
        $conexion = new conexion();
        $sql = "SELECT * FROM comunas";
        $resultado = $conexion->crearConexion()->prepare($sql);
        $resultado->execute();


        return $resultado->fetchAll();
    }




    /**
     * Funcion muestra los candidatos
     * almacenados en la tabla candidatos
     * retorna el arreglo de candidatos
     */



    function mostrarCandidatos()
    {
        $conexion = new conexion();
        $sql = "SELECT * FROM candidato";
        $resultado = $conexion->crearConexion()->prepare($sql);
        $resultado->execute();

        return $resultado->fetchAll();
    }



    /**
     * Funcion contabiliza el numero de votos
     * retorna contador de votos.
     * 
     */

    function contadorVotos()
    {
        $conexion = new conexion();
        $sql = "SELECT * FROM votante";
        $resultado = $conexion->crearConexion()->prepare($sql);
        $resultado->execute();
        $cont = 0;
        $re = $resultado->fetchAll();
        foreach ($re as $numero) {
            $cont += 1;
        }



        return $cont;
    }


    
    /**
     * Funcion ultimoVotante muestra 
     * el ultimo rut que voto en el sistema.
     * 
     */


    function ultimoVotante()
    {
        $conexion = new conexion();
        $sql = "SELECT rut FROM votante ORDER BY id_voto desc";
        $resultado = $conexion->crearConexion()->prepare($sql);
        $resultado->execute();
        $votante = $resultado->fetchColumn();


        return $votante;
    }


    /**
     * Funcion selectComuna recibe el input region por ajax
     * lo utiliza en la query de buscar comuna, retorna los valores 
     * cuando x comuna pertenece a x region
     */

    function selectcomuna()
    {
        $region = filter_input(INPUT_POST, 'region');
        $conexion = new conexion();
        $sql = "SELECT * FROM comunas where id_nro_region='" . $region . "'";
        $resultado = $conexion->crearConexion()->prepare($sql);
        $resultado->execute();
        $final = $resultado->fetchAll();
        return $final;
    }




    /**
     * Funcion validarRut Valida rut para no
     * generar error de ingreso en el formulario
     * repeticion de rut...
     */

    function validarRut()
    {
        $conexion = new conexion();
        $sql = "SELECT * FROM votante";
        $resultado = $conexion->crearConexion()->prepare($sql);
        $resultado->execute();
        $mostrar = $resultado->fetchAll();
        return $mostrar;
    }




    /**
     * Funcion insertarVokto genera ingresos en la bd
     * utiliza como parametros el objeto votante
     * y los valores de checked, que estan en formato json
     */

    function insertarVoto($votante, $cheked)
    {
        try{
            $conexion = new conexion();
            $sql = "INSERT INTO votante values(
                0,'" . $votante->getNombreCompleto() . "','" . $votante->getAlias() . "',
                '" . $votante->getRut() . "','" . $votante->getEmail() . "','" . $cheked . "',
                '" . $votante->getRegion() . "','" . $votante->getComuna() . "','" . $votante->getCandidato() . "'
            )";
            $resultado = $conexion->crearConexion()->prepare($sql);
            $resultado->execute();
            $final = $resultado->fetchAll();
            return $final;
        }
        catch(Exception $ex){
            print_r('Error contacte con administrador: '.$ex->getMessage());

        }

       
    }
}
