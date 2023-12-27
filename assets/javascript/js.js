

/**
 *  Script javascript
 *  se ejecuta en modo estricto para manejar mejor las variables, o identificar errores dentro del codigo.
 * 
 *  Funcion addeventlistener para validar los input que se enviara en el formulario
 *  Se aplica destructuracion para obtener los valores del elemento form
 * 
 *  funcion addeventlistener para validar el rut.
 * 
 * 
 *  funcion que generara el numero verificador al estar tipeando dentro del input de rut
 *  se considerara que el rut tenga al menos  7 caracteres y un maximo de 8 (sin contar el verificador ya que este se generara solo)
 *
 * 
 */



(() => {
    'use strict'

    /**
     * constantes llama elementos del DOM
     */

    const form = document.querySelector('form');
    const btnVotar = document.querySelector('#inputVotar');
    const mensaje = document.querySelector('#mensaje');
    const checkede = document.querySelectorAll('.coption');
    const { nombreCompleto, alias, email, rut, verificador, nro_region, comuna, r_candidato } = form.elements;

    /**
     *  constantes, almacenan expresiones regulares, para posteriormente 
     *  evaluar una variable, resultado, etc.
     * 
     */


    /** 
     * vaciamos al principio los list
     * 
     * 
    */

    nro_region.value = "";
    comuna.value = "";
    r_candidato.value = "";



    const validarAlias = /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]+$/;
    const validarCorreo = /^[a-z0-9._%+-].*\@.+\.[a-z]{2,}$/;
    const validarRut = /^[0-9]*$/;





    /**
     * En caso de existir form en el DOM
     * ejecutar el siguiente codigo...
     */
    ;



    if (form) {


        btnVotar.addEventListener('click', (e) => {
            e.preventDefault();
            let contadorCheck = 0;
            for (var i = 0; i < checkede.length; i++) {
                if (checkede[i].checked) {

                    contadorCheck += 1;

                }


            }



            /**
             * EN CASO DE ERROR LA VARIABLE MSJ 
             * ALMACENARA EL ERROR CORRESPONDIENTE SEGUN EL CONDICIONAL
             */


            let msj = '';

            if (nombreCompleto.value == "") {

                msj = 'EL CAMPO NOMBRE DEBE TENER POR LO MENOS UN CARACTER';

            }
            else if (alias.value == "" || alias.value.length < 5 || !validarAlias.test(alias.value)) {

                msj = 'EL ALIAS DEBE SER DE 5 CARACTER Y CONTENER NUMERO';

            }

            else if (!validarCorreo.test(email.value)) {

                msj = 'CORREO NO VALIDO, PORFAVOR VERIFICAR';

            }
            else if (rut.value.length < 7 || rut.value.length >= 9 || !validarRut.test(rut.value)) {
                msj = 'RUT NO VALIDO';
            }

            else if (nro_region.value == "") {
                msj = 'SELECCIONE UNA REGION';
            }
            else if (comuna.value == "") {
                msj = 'SELECCIONE UNA COMUNA';
            }

            else if (r_candidato.value == "") {
                msj = 'SELECCIONE UN CANDIDATO';
            }

            else if (contadorCheck < 2) {
                msj = 'DEBE SELECCIONAR AL MENOS 2 CHECKED';

            }


            else {


                /**
    
                FINALMENTE AL NO EXISTIR ERRORES, SE HARA UN SUBMIT DEL FORMULARIO
                PARA POSTERIORMENTE SER CARGADA LA INFORMACION EN EL BACKEND
                 */
                form.submit();


            }


            mensaje.innerHTML = msj;
            mensaje.classList.add('error');


        })

    }


    /**
     * En caso de existir input con la clase rut en el DOM
     * ejecutar el siguiente codigo...
     */

    if (rut) {
        rut.addEventListener('input', (e) => {



            let valor = rut.value;
            valor = e.target.value.replace(/[a-zA-Z\s]/g, '');
            rut.value = valor;



            (rut.value.length > 8) ? rut.value = rut.value.slice(0, 8) : "";


            (e.target.value.length >= 7 && e.target.value.length < 9) ? verificador.value = verificadorRut(e.target.value) : verificador.value = "";




        });

    }



    /**
     * en caso de existir el input alias 
     * y el input email, generar la validacion
     * de la funcion campoVacio
     * 
     */


    if (alias && email) {



        alias.addEventListener('input', (e) => {

            campoVacio(alias, e);



        })

        email.addEventListener('input', (a) => {


            campoVacio(email, a);




        })


    }





    /**
     * funcion verifica el rut ingresado en el input rut
     * se usa operador spread para transformar el parametro rut (String a array)
     * la funcion reverse cambiar el sentido de los elementos 
     * se itera los valores, mientras el contador sea menor igual a 7 se repetira y volvera a 2
     * a la vez se va multiplicando el contador (2-7) por el valor del array en x posicion.
     * 
     * finalmente se divide por 11, el resultado se multiplica por 11 
     * posteriormente el primera acumulacion dentro del for se restara a la operacion anterior.
     * finalmente se tiene el resultado al restar 11 con el resultado de la operacion anterior.
     * 
     * se aplica operador ternario, si el resultado es 11 el verificador sera 0, si el resultado es 10 es K
     * los demas resultados representan su mismo valor (0......9)
     * 
     * finalmente la funcion retorna el verificador
     * 
     */


    const verificadorRut = (([...rut]) => {
        let cont = 1;
        let contindice = 1;
        let acumular = 0;

        rut.reverse();

        rut.forEach(valores => {
            do {


                cont = cont + 1;
                acumular = acumular + (valores * cont);
                contindice = contindice + 1;

                if (cont >= 7) {
                    cont = 1;

                }


            }
            while (valores.length == contindice);

        });

        let div = Math.floor(acumular / 11);
        let mul = div * 11;
        let res = (acumular - mul);
        let resultado = (11 - res);


        return (resultado == 11) ? resultado = 0 : (resultado == 10) ? resultado = "k" : resultado = resultado;



    })




    /**
     * 
     *  Funcion con expresion regular
     *  eliminar los espacios en un input
     * 
     * 
     */

    const campoVacio = ((variable, event) => {

        let valor = variable.value;
        valor = event.target.value.replace(/\s/g, '');
        variable.value = valor;

    })



    /**
     * 
     *  Funcion EN AJAX
     *  LA LOGICA ES, SI EL USUARIO SELECCIONA UNA VALOR EN LA LISTA REGION
     *  ENVIARA EL ID DE EL NRO DE REGION AL BACKEND EN PHP,
     *  ESTE SERA UTILIZADO PARA EVALUAR POR MEDIO DE UNA NUEVA QUERY
     *  LA CUAL DEVOLVERA LAS COMUNAS ASOCIADAS POR LA FK ENTRE REGION.
     *  FINALMENTE SE CARGARAN LOS VALORES CON LA FUNCION .HTML
     * 
     */


    $(document).ready(function () {
        $(nro_region).change(function (e) {
            var region = $(this).val();
            var comuna = $('#comuna');


            $.ajax({
                data: { region: region },
                dataType: 'html',
                type: "POST",
                url: 'comunas.php',

            }).done(function (data) {

                comuna.html(data);

            });




        });

    });

})();






