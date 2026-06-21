const urlParams = new URLSearchParams(window.location.search);
const msg = urlParams.get('msg');

const successEl = document.getElementById('form-alert-success');
const infoEl = document.getElementById('form-alert-info');

const successMessages = {
    requested: ' Request sent! Waiting for driver approval.',
    updated: ' Your request has been updated.'
};

const infoMessages = {
    already_requested: ' You\'ve already requested this ride.'
};

if (msg && successMessages[msg]) {
    successEl.textContent = successMessages[msg];
    successEl.style.display = 'flex';
} else if (msg && infoMessages[msg]) {
    infoEl.textContent = infoMessages[msg];
    infoEl.style.display = 'flex';
}