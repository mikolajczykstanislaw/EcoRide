const btn = document.querySelector("button");
const menu = document.getElementById("mobile-menu");

btn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
});

// Skrypt do otwierania modali logowania i rejestracji
document.querySelectorAll('a[href="#login-modal"]').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('login-modal').classList.remove('hidden');
    });
});
document.querySelectorAll('a[href="#register-modal"]').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('register-modal').classList.remove('hidden');
    });
});

function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// Odczytanie błędu z URL i wyświetlenie go
const errorMessage = getQueryParam('error');
if (errorMessage) {
    document.getElementById('error-message').innerText = errorMessage;
    document.getElementById('register-modal').classList.remove('hidden'); // Ujawnij modal
}

const successMessage = getQueryParam('success'); // Poprawiono na successMessage
if (successMessage) {
    document.getElementById('success-message').innerText = successMessage;
    document.getElementById('register-modal').classList.remove('hidden'); // Ujawnij modal
}

const errorMessageLogin = getQueryParam('error-login');
if (errorMessageLogin) {
    document.getElementById('error-message-login').innerText = errorMessageLogin;
    document.getElementById('login-modal').classList.remove('hidden'); // Pokaż modal logowania
}

const successMessageLogin = getQueryParam('success-login');
if (successMessageLogin) {
    document.getElementById('success-message-login').innerText = successMessageLogin;
    document.getElementById('login-modal').classList.remove('hidden'); // Pokaż modal logowania
}