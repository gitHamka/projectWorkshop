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
