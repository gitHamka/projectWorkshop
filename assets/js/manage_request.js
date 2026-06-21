const urlParams = new URLSearchParams(window.location.search);
const msg = urlParams.get('msg');

const successEl = document.getElementById('form-alert-success');

const messages = {
    approved: '✅ Request approved.',
    rejected: '❌ Request rejected.'
};

if (msg && messages[msg]) {
    successEl.textContent = messages[msg];
    successEl.style.display = 'flex';
}