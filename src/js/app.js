document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();
});

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);


    /***********************************************************************************/
    // Muestra campos del formulario de forma condicional
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');
    // Itera en el select del formulario y pone un eventlistener a cada uno
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodoContacto));
    /************************************************************************************/



    // Eliminar texto de confirmación de CRUD en admin/index.php
    setTimeout(function(){        
        const mensajeConfirm = document.querySelector('.alerta.exito');
        if(mensajeConfirm) {
        const padre = mensajeConfirm.parentElement;
        padre.removeChild(mensajeConfirm);}
    }, 3000);
}

function mostrarMetodoContacto(){
    console.log('Seleccionando...');
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar')
}