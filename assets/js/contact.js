const form = document.getElementById('contactForm');
const formAlert = document.getElementById('form-alert');
const urlParams = new URLSearchParams(window.location.search);
const error = urlParams.get('error');

if (error === 'invalid_input') {
    formAlert.textContent = '⚠ Please check your details — only UTeM emails are accepted.';
    formAlert.style.display = 'flex';
}

function showErr(id, msg) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.style.display = 'block';
}

function clearErr(id) {
    const el = document.getElementById(id);
    el.textContent = '';
    el.style.display = 'none';
}

form.addEventListener('submit', function (e) {
    let valid = true;
    formAlert.style.display = 'none';

    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();

    if (name.length < 3) {
        showErr('err-name', '⚠ Name must be at least 3 characters.');
        valid = false;
    } else {
        clearErr('err-name');
    }

    const allowedDomain = "student.utem.edu.my";
    const emailDomain = email.split('@')[1] || '';
    if (!email) {
        showErr('err-email', '⚠ Email is required.');
        valid = false;
    } else if (emailDomain !== allowedDomain) {
        showErr('err-email', '⚠ Only UTeM emails allowed (@student.utem.edu.my).');
        valid = false;
    } else {
        clearErr('err-email');
    }

    if (!message) {
        showErr('err-message', '⚠ Message cannot be empty.');
        valid = false;
    } else {
        clearErr('err-message');
    }

    if (!valid) {
        formAlert.textContent = 'Please fix the errors below before submitting.';
        formAlert.style.display = 'flex';
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

