const USER_API = 'services/private/administrador.php'; // URL de la API para interactuar con los administradores
const SIGNUP_FORM = document.getElementById('signupForm'); // Formulario de registro del primer usuario
const LOGIN_FORM = document.getElementById('loginForm'); // Formulario de inicio de sesión
const MAIN_TITLE = document.getElementById('mainTitle'); // Título del contenido principal (asegúrate de que este elemento existe en tu HTML)

// Función para cargar plantillas (debes definir esta función según tus necesidades)
function loadTemplate() {
    console.log('loadTemplate function is called'); // Puedes eliminar esta línea cuando hayas agregado la lógica necesaria.
}

document.addEventListener('DOMContentLoaded', async () => {
    try {
        loadTemplate(); // Llama a la función loadTemplate para cargar el contenido o las plantillas necesarias

        // Petición para consultar los usuarios registrados
        const DATA = await fetchData(USER_API, 'readUsers');

        // Comprobación de la existencia de sesión
        if (DATA.session) {
            // Redirige a la página de bienvenida si hay sesión activa
            location.href = 'inicioCecot.html';
        } else if (DATA.status) {
            // Muestra el formulario de inicio de sesión si no hay sesión activa pero se obtiene un estado correcto
            MAIN_TITLE.textContent = 'Iniciar sesión';
            LOGIN_FORM.classList.remove('d-none');
            sweetAlert(4, DATA.message, true);
        } else {
            // Muestra el formulario para registrar el primer usuario si no hay sesión y el estado no es correcto
            MAIN_TITLE.textContent = 'Registrar primer usuario';
            SIGNUP_FORM.classList.remove('d-none');
            sweetAlert(4, DATA.error, true);
        }
    } catch (error) {
        // Manejo de errores en caso de fallos en la petición o en la lógica
        console.error('Error en la carga de datos o en la lógica del DOM:', error);
        sweetAlert(2, 'Ha ocurrido un error inesperado. Por favor, intenta nuevamente.', false);
    }
});

// Maneja el envío del formulario de registro del primer usuario
SIGNUP_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evita que el formulario recargue la página

    try {
        const FORM = new FormData(SIGNUP_FORM); // Crea un FormData con los datos del formulario
        const DATA = await fetchData(USER_API, 'signUp', FORM); // Petición para registrar el primer usuario

        if (DATA.status) {
            // Si la respuesta es exitosa, muestra un mensaje de éxito y redirige a la página de inicio
            sweetAlert(1, DATA.message, true, 'Index.html');
        } else {
            // Si la respuesta no es exitosa, muestra un mensaje de error
            sweetAlert(2, DATA.error, false);
        }
    } catch (error) {
        // Manejo de errores en caso de fallos en la petición
        console.error('Error al enviar el formulario de registro:', error);
        sweetAlert(2, 'Ha ocurrido un error al intentar registrar. Por favor, intenta nuevamente.', false);
    }
});

// Maneja el envío del formulario de inicio de sesión
LOGIN_FORM.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evita que el formulario recargue la página

    try {
        const FORM = new FormData(LOGIN_FORM); // Crea un FormData con los datos del formulario
        const DATA = await fetchData(USER_API, 'logIn', FORM); // Petición para iniciar sesión

        if (DATA.status) {
            // Si la respuesta es exitosa, muestra un mensaje de éxito y redirige a la página de inicio
            sweetAlert(1, DATA.message, true, 'Index.html');
        } else {
            // Si la respuesta no es exitosa, muestra un mensaje de error
            sweetAlert(2, DATA.error, false);
        }
    } catch (error) {
        // Manejo de errores en caso de fallos en la petición
        console.error('Error al enviar el formulario de inicio de sesión:', error);
        sweetAlert(2, 'Ha ocurrido un error al intentar iniciar sesión. Por favor, intenta nuevamente.', false);
    }
});
