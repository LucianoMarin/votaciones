<?php

// Clase votante, esta clase permite encapsular la informacion.
// se emplea constructor vacio.


class votante
{

    /**
     * ATRIBUTOS
     * @ var String $nombreCompleto
     * @ var String $alias
     * @ var String $rut
     * @ var String $email
     */


    public $nombreCompleto;
    public $alias;
    public $rut;
    public $email;
    public $region;
    public $comuna;
    public $candidato;


    /**
     * 
     * Constructor vacio.
     */
    function ___construc()
    {
    }


    function setnombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }



    /**
     * 
     * INICIO GETER AND SETER
     */

    function getnombreCompleto()
    {

        return $this->nombreCompleto;
    }


    function setAlias($alias)
    {
        $this->alias = $alias;
    }


    function getAlias()
    {

        return $this->alias;
    }


    function setRut($rut)
    {
        $this->rut = $rut;
    }

    function getRut()
    {

        return $this->rut;
    }

    function setEmail($email)
    {

        $this->email = $email;
    }

    function getEmail()
    {
        return $this->email;
    }


    function setRegion($region)
    {

        $this->region = $region;
    }

    function getRegion()
    {
        return $this->region;
    }



    function setComuna($comuna)
    {

        $this->comuna = $comuna;
    }

    function getComuna()
    {
        return $this->comuna;
    }



    function setCandidato($candidato)
    {

        $this->candidato = $candidato;
    }

    function getCandidato()
    {
        return $this->candidato;
    }




    /**
     * 
     * FIN GETER AND SETER
     */



    function __destruct()
    {
    }
}
