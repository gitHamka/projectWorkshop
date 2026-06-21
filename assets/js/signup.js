const form       = document.getElementById('signupForm');
const formAlert  = document.getElementById('form-alert');
const pwInput    = document.getElementById('password');
const strengthBar   = document.getElementById('strength-bar');
const strengthLabel = document.getElementById('strength-label');

function showErr(id, msg) {
    const el = document.getElementById(id);
    el.textContent = '⚠ ' + msg;
    el.style.display = 'block';
}
function clearErr(id) {
    const el = document.getElementById(id);
    el.textContent = '';
    el.style.display = 'none';
}
function markError(inputId, errId, msg) {
    const input = document.getElementById(inputId);
    if (input) input.classList.add('input-error');
    showErr(errId, msg);
}
function clearInput(inputId, errId) {
    const input = document.getElementById(inputId);
    if (input) input.classList.remove('input-error');
    clearErr(errId);
}

['name','matric_id','email','password'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', () => clearInput(id, 'err-' + (id === 'matric_id' ? 'matric' : id)));
});

pwInput.addEventListener('input', function() {
    const val = this.value;
    strengthBar.className = 'password-strength';
    if (val.length === 0) {
        strengthLabel.textContent = '';
        return;
    }
    let score = 0;
    if (val.length >= 6) score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;

    if (score === 1) {
        strengthBar.classList.add('strength-weak');
        strengthLabel.style.color = '#EF5350';
        strengthLabel.textContent = 'Weak password';
    } else if (score === 2) {
        strengthBar.classList.add('strength-medium');
        strengthLabel.style.color = '#FFA726';
        strengthLabel.textContent = 'Medium password';
    } else {
        strengthBar.classList.add('strength-strong');
        strengthLabel.style.color = '#66BB6A';
        strengthLabel.textContent = 'Strong password ✓';
    }
});

form.addEventListener('submit', function(e) {
    let valid = true;
    formAlert.style.display = 'none';

    const name    = document.getElementById('name').value.trim();
    const matric  = document.getElementById('matric_id').value.trim();
    const email   = document.getElementById('email').value.trim();
    const password = pwInput.value;
    const terms   = document.getElementById('terms').checked;

    if (!name) {
        markError('name', 'err-name', 'Full name is required.'); valid = false;
    } else if (name.length < 3) {
        markError('name', 'err-name', 'Name must be at least 3 characters.'); valid = false;
    }

    if (!matric) {
        markError('matric_id', 'err-matric', 'Matric / Staff ID is required.'); valid = false;
    } else if (matric.length < 5) {
        markError('matric_id', 'err-matric', 'Matric / Staff ID seems too short.'); valid = false;
    }

    const utemDomains = ['student.utem.edu.my', 'utem.edu.my'];
    const emailDomain = email.split('@')[1] || '';
    if (!email) {
        markError('email', 'err-email', 'Email is required.'); valid = false;
    } else if (!email.includes('@')) {
        markError('email', 'err-email', 'Please enter a valid email address.'); valid = false;
    } else if (!utemDomains.includes(emailDomain)) {
        markError('email', 'err-email', 'Only UTeM emails allowed ( @student.utem.edu.my or @utem.edu.my).'); valid = false;
    }

    if (!password) {
        markError('password', 'err-password', 'Password is required.'); valid = false;
    } else if (password.length < 6) {
        markError('password', 'err-password', 'Password must be at least 6 characters.'); valid = false;
    }

    if (!valid) {
        formAlert.textContent = '❌ Please fix the errors below before signing up.';
        formAlert.style.display = 'flex';
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

const urlParams = new URLSearchParams(window.location.search);
const error = urlParams.get('error');
const formAlertEl = document.getElementById('form-alert');

const signupErrorMessages = {
    duplicate_matric: ' This Matric/Staff ID is already registered. Please log in instead.',
    duplicate_email: ' This email is already registered. Please log in instead.',
    signup_failed: ' Something went wrong during signup. Please try again.'
};

if (error && signupErrorMessages[error]) {
    formAlertEl.textContent = signupErrorMessages[error];
    formAlertEl.style.display = 'flex';
}