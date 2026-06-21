const loginForm = document.getElementById('loginForm');
const matricInput = document.getElementById('matric_number');
const passwordInput = document.getElementById('password');
const formAlert = document.getElementById('form-alert');

function showFieldError(inputEl, errId, message) {
    inputEl.classList.add('input-error');
    const errEl = document.getElementById(errId);
    errEl.textContent = '⚠ ' + message;
    errEl.style.display = 'block';
}

function clearFieldError(inputEl, errId) {
    inputEl.classList.remove('input-error');
    document.getElementById(errId).style.display = 'none';
}

function showFormAlert(message) {
    formAlert.textContent = '❌ ' + message;
    formAlert.style.display = 'flex';
}

matricInput.addEventListener('input', () => clearFieldError(matricInput, 'err-matric'));
passwordInput.addEventListener('input', () => clearFieldError(passwordInput, 'err-password'));

loginForm.addEventListener('submit', function(e) {
    let valid = true;
    formAlert.style.display = 'none';

    const matric = matricInput.value.trim();
    const password = passwordInput.value;

    if (!matric) {
        showFieldError(matricInput, 'err-matric', 'Please enter your Matric / Staff ID.');
        valid = false;
    } else if (matric.length < 5) {
        showFieldError(matricInput, 'err-matric', 'Matric / Staff ID is too short.');
        valid = false;
    }

    if (!password) {
        showFieldError(passwordInput, 'err-password', 'Please enter your password.');
        valid = false;
    } else if (password.length < 6) {
        showFieldError(passwordInput, 'err-password', 'Password must be at least 6 characters.');
        valid = false;
    }

    if (!valid) {
        showFormAlert('Please fix the errors above before logging in.');
        e.preventDefault();
    }
});

const togglePassword = document.getElementById('togglePassword');
const passwordField = document.getElementById('password');

togglePassword.addEventListener('click', function() {
    const isHidden = passwordField.type === 'password';
    passwordField.type = isHidden ? 'text' : 'password';
    this.textContent = isHidden ? '🙈' : '👁️';
});