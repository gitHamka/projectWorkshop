document.getElementById('sosTrigger').addEventListener('click', () => {
    navigator.geolocation.getCurrentPosition((position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        
        fetch('../safety/send_sos.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `lat=${lat}&lng=${lng}`
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('statusMessage').innerText = "SOS Dispatched! Coordinates sent securely. Campus security notified.";
        });
    }, () => {
        // return if loc tracking block active
        fetch('../safety/send_sos.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `lat=UNKNOWN&lng=UNKNOWN`
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('statusMessage').innerText = "SOS Broadcasted without GPS context metadata.";
        });
    });
});
