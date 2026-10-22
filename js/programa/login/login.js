// Sitio Web Creado por ITred Spa.
// Direccion: Guido Reni #4190
// Pedro Aguirre Cerda - Santiago - Chile
// contacto@itred.cl o itred.spa@gmail.com
// https://www.itred.cl
// Creado, Programado y Diseñado por ITred Spa.
// BPPJ



// -------------------------------------------------------------------------------------------------------------
// -------------------------------------- INICIO ITred Spa login .JS -------------------------------------------
// -------------------------------------------------------------------------------------------------------------


// TITULO BODY

    // sin funcion


// TITULO CONTENEDOR LOGIN

    // sin funcion


// TITULO CONTENEDOR FORMULARIO LOGIN

    // sin funcion


// TITULO TITULO LOGIN

    // sin funcion


// TITULO MENSAJE LOGIN

    // sin funcion


// TITULO FORMULARIO LOGIN

    document.addEventListener("DOMContentLoaded", function(){

        // referencia al formulario login
        const formularioLogin = document.getElementById("form_login");

        // referencia al mensaje de respuesta
        const respuestaLogin = document.getElementById("login_respuesta");

        // valida existencia del formulario
        if(!formularioLogin){
            return;
        }

        // evento submit del formulario
        formularioLogin.addEventListener("submit", function(evento){

            // referencia al campo usuario
            const campoUsuario = document.getElementById("usuario");

            // referencia al campo password
            const campoPassword = document.getElementById("password");

            // obtiene valor usuario sin espacios extremos
            const valorUsuario = campoUsuario.value.trim();

            // obtiene valor password sin espacios extremos
            const valorPassword = campoPassword.value.trim();

            // valida usuario vacio
            if(valorUsuario === ""){
                evento.preventDefault();
                respuestaLogin.textContent = "Debe ingresar su usuario.";
                campoUsuario.focus();
                return;
            }

            // valida password vacia
            if(valorPassword === ""){
                evento.preventDefault();
                respuestaLogin.textContent = "Debe ingresar su contraseña.";
                campoPassword.focus();
                return;
            }

            // limpia mensaje si todo esta correcto
            respuestaLogin.textContent = "";
        });

    });


// TITULO CAMPO USUARIO

    // sin funcion


// TITULO CAMPO PASSWORD

    // sin funcion


// TITULO MENSAJE RESPUESTA LOGIN

    // sin funcion


// TITULO BOTON LOGIN

    // sin funcion



// -------------------------------------------------------------------------------------------------------------
// ---------------------------------------- FIN ITred Spa login .JS --------------------------------------------
// -------------------------------------------------------------------------------------------------------------



// Sitio Web Creado por ITred Spa.
// Direccion: Guido Reni #4190
// Pedro Aguirre Cerda - Santiago - Chile
// contacto@itred.cl o itred.spa@gmail.com
// https://www.itred.cl
// Creado, Programado y Diseñado por ITred Spa.
// BPPJ