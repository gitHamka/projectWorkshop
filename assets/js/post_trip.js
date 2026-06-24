function selectSeats(el, val) {
    document.querySelectorAll('.option-selector-group .selector-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('seats_available').value = val;
}
function selectGender(el, val) {
    document.querySelectorAll('.gender-selector-group .selector-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('gender_preference').value = val;
}
