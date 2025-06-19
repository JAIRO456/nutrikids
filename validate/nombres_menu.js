const form = document.getElementById('form');
const inputs = document.querySelectorAll('#form input, #form textarea');

const palabras_reservadas = ['admin', 'administrador', 'root', 'system', 'select', 'insert', 'delete', 'update'];

const expres = {
    nombre_menu: /^[a-zA-ZÀ-ÿ0-9]+(?:\s[a-zA-ZÀ-ÿ0-9]+)*$/
}

const campos = {
    nombre_menu: false
}

const validateForm = (e) => {
    switch (e.target.name){
        case "nombre_menu":
            validarPalabrasReservadas(e.target);
            state(expres.nombre_menu, e.target, 'nombre_menu');
        break;
    }
}

const validarPalabrasReservadas = (input) => {
    const valor = input.value.toLowerCase();
    for (const palabra of palabras_reservadas) {
        if (valor.includes(palabra)) {
            alert('El nombre del menú no puede contener palabras reservadas');
            input.value = '';
            campos.nombre_menu = true;
            state(expres.nombre_menu, input, 'nombre_menu');
            return;
        }
    }
}

const state = (expres, input, x) => {
    const element = document.getElementById(`x_${x}`);
    if (!element) {
        console.error(`Elemento con id x_${x} no encontrado`);
        return;
    }

    if(expres.test(input.value)){
        element.classList.remove('x_grupo-incorrecto');
        element.classList.add('x_grupo-correcto');
        element.querySelector('i').classList.remove('fa-exclamation-circle');
        element.querySelector('i').classList.add('fa-check-circle');
        element.querySelector('.x_typerror').classList.remove('x_typerror-block');
        campos[x] = false;
    } else {
        element.classList.add('x_grupo-incorrecto');
        element.classList.remove('x_grupo-correcto');
        element.querySelector('i').classList.add('fa-exclamation-circle');
        element.querySelector('i').classList.remove('fa-check-circle');
        element.querySelector('.x_typerror').classList.add('x_typerror-block');
        campos[x] = true;
    }
}

form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    inputs.forEach((input) => {
        validateForm({ target: input });
    });

    if (!Object.values(campos).some(campo => campo === true)) {
        form.submit();
    } else {
        alert('Por favor, complete correctamente todos los campos antes de enviar el formulario.');
    }
});

inputs.forEach((input) => {
    input.addEventListener('keyup', validateForm);
    input.addEventListener('blur', validateForm);
});