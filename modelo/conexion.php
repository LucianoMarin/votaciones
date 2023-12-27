<?php


// Clase Conexion, esta clase permite generar una conexion con la base de datos.



class conexion
{


    /**
     * ATRIBUTOS
     * @ var String $url almacenara el host
     * @ var String $usuarioDB almacenara el usuario de DB
     * @ var String $claveDB almacenara clave DB
     */
    

    public $url="localhost";
    public $usuarioDB="root";
    public $claveDB="";



    function crearConexion()
    {
        
        try{

        $conexion = new PDO("mysql:dbname=votaciones; host=$this->url", $this->usuarioDB, $this->claveDB);
        $conexion->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);

        }catch(Exception $ex){

            $error=$ex->getMessage();
            /**
             * 
             * Excepcion, en caso de haber un error en la bd, redirecciona a la vistas error.
             */

            header('Location:  ../formulario/vistas/error/index.php');

        }

    

        return $conexion;
        
   
    }



}


?>