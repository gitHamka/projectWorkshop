const roleSelect = document.getElementById('roleSelect');
const carModel = document.getElementById('car_model');
const plateNumber = document.getElementById('plate_number');
const color = document.getElementById('color');

function toggleVehicleRequired() {
    const isDriver = roleSelect.value === 'Driver';
    carModel.required = isDriver;
    plateNumber.required = isDriver;
    color.required = isDriver;
}

roleSelect.addEventListener('change', toggleVehicleRequired);
toggleVehicleRequired(); 

const urlParams = new URLSearchParams(window.location.search);
const error = urlParams.get('error');

const formAlert = document.getElementById('form-alert');

const errorMessages = {
    duplicate_plate: ' This plate number is already registered to another account. Please check and try again.',
    duplicate_matric: ' This Matric/Staff ID is already registered. Please check and try again.'
};

if (error && errorMessages[error]) {
    formAlert.textContent = errorMessages[error];
    formAlert.style.display = 'flex';
}