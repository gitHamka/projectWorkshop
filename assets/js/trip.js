function validateTripForm() {
    const pickup = document.getElementById('pickup').value;
    const dropoff = document.getElementById('dropoff').value;
    if (pickup === dropoff) {
        alert("Pickup location and Dropoff location cannot be identical.");
        return false;
    }
    return true;
}