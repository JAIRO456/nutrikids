const form = document.getElementById('form');
const inputs = document.querySelectorAll('#form input');

const expres = {
    nombre: /^[a-zA-ZÀ-ÿ\s]{1,50}$/,
    apellido: /^[a-zA-ZÀ-ÿ\s]{1,50}$/,
    documento: /^\d{10,11}$/,
    email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    telefono: /^\d{10,12}$/,
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/,
    escuela: /^.+$/
}

const campos = {
    nombre: false,
    apellido: false,
    documento: false,
    email: false,
    telefono: false,
    password: false,
    escuela: false
}

const validateForm = (e) => {
    switch (e.target.name){
        case "nombre":
            state(expres.nombre, e.target, 'nombre');
        break;
        case "apellido":
            state(expres.apellido, e.target, 'apellido');
        break;
        case "documento":
            state(expres.documento, e.target, 'documento');
        break;
        case "email":
            state(expres.email, e.target, 'email');
        break;
        case "telefono":
            state(expres.telefono, e.target, 'telefono');
        break;
        case "password":
            state(expres.password, e.target, 'password');
        break;
        case "escuela":
            state(expres.escuela, e.target, 'escuela');
        break;
    }
}

const state = (expres, input, x) => {
    const element = document.getElementById(`x_${x}`);
    if (!element) {
        console.error(`Elemento con id x_${x} no encontrado`);
        return;
    }

    if(expres.test(input.value)){
        document.getElementById(`x_${x}`).classList.remove('x_grupo-incorrecto');
        document.getElementById(`x_${x}`).classList.add('x_grupo-correcto');
        document.querySelector(`#x_${x} i`).classList.remove('fa-exclamation-circle');
        document.querySelector(`#x_${x} i`).classList.add('fa-check-circle');
        document.querySelector(`#x_${x} .x_typerror`).classList.remove('x_typerror-block');
        campos[x] = false;
    } 
    else {
        document.getElementById(`x_${x}`).classList.add('x_grupo-incorrecto');
        document.getElementById(`x_${x}`).classList.remove('x_grupo-correcto');
        document.querySelector(`#x_${x} i`).classList.add('fa-exclamation-circle');
        document.querySelector(`#x_${x} i`).classList.remove('fa-check-circle');
        document.querySelector(`#x_${x} .x_typerror`).classList.add('x_typerror-block');
        campos[x] = true;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', validateForm);
    input.addEventListener('blur', validateForm);
});

/* form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Validar todos los campos antes del envío
    inputs.forEach((input) => {
        validateForm({ target: input });
    });

    // Verificar si hay campos inválidos
    const hayErrores = Object.values(campos).some(campo => campo === true);
    
    if (hayErrores) {
        alert('Por favor, complete correctamente todos los campos antes de enviar el formulario.');
    } else {
        form.submit();
    }
}); */