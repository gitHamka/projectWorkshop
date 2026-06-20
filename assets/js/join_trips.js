function selectSeatsRequested(el, val) {
    document.querySelectorAll('.option-selector-group .selector-item').forEach(i => i.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('seats_requested').value = val;
}