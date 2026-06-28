// Approximate distances (km) between campus/off-campus locations.
// Key format: "locationA|locationB" (lowercase). Add more pairs as needed.
const distanceTable = {
    "ftmk / faix|ftke": 0.4,
    "ftmk / faix|ftkek": 0.5,
    "ftmk / faix|ftkip": 0.6,
    "ftmk / faix|ftkm": 0.5,
    "ftmk / faix|pbb": 0.3,
    "ftmk / faix|perpustakaan": 0.7,
    "ftmk / faix|canselori": 0.8,
    "ftmk / faix|dewan canselor": 0.9,
    "ftmk / faix|pku": 0.6,
    "ftmk / faix|pusat sukan / stadium": 1.0,
    "ftmk / faix|masjid / tasik 1 & 2": 0.8,
    "ftmk / faix|pusat persatuan pelajar": 0.7,
    "ftmk / faix|kk satria": 1.2,
    "ftmk / faix|kk lestari": 1.5,
    "ftmk / faix|kk al-jazari": 1.3,
    "ftmk / faix|cafe 1": 0.4,
    "ftmk / faix|cafe 2": 0.5,
    "ftmk / faix|cafe satria": 1.1,
    "ftmk / faix|cafe lestari": 1.4,
    "ftmk / faix|ftkmp": 3.5,
    "ftmk / faix|fptt": 3.8,
    "ftmk / faix|melaka sentral": 12.0,
    "ftmk / faix|mydin mitc": 8.5,
    "ftmk / faix|aeon ayer keroh": 6.0,
    "ftmk / faix|mitc": 8.0,
    "ftmk / faix|ayer keroh heights": 4.0,
    "ftmk / faix|bukit beruang": 2.5,
    "ftmk / faix|durian tunggal": 9.0

    // Add more pairs here in the same "a|b": km format as you confirm real distances.
    // Only one direction needs to be listed -- lookupDistance() checks both ways.
};

function getDistanceKey(a, b) {
    return a.trim().toLowerCase() + "|" + b.trim().toLowerCase();
}

function lookupDistance() {
    const originSelect = document.getElementById('origin');
    const destSelect    = document.getElementById('destination');

    const origin = originSelect.value === 'Lain-Lain' ? null
                 : (document.getElementById('origin_other').style.display !== 'none' ? null : originSelect.value);
    const dest   = destSelect.value === 'Lain-Lain' ? null
                 : (document.getElementById('destination_other').style.display !== 'none' ? null : destSelect.value);

    // If either side is "Lain-Lain" (hometown), don't auto-fill -- let driver type manually.
    if (!origin || !dest) {
        return;
    }

    const keyForward  = getDistanceKey(origin, dest);
    const keyBackward = getDistanceKey(dest, origin);

    let km = null;
    if (distanceTable.hasOwnProperty(keyForward)) {
        km = distanceTable[keyForward];
    } else if (distanceTable.hasOwnProperty(keyBackward)) {
        km = distanceTable[keyBackward];
    }

    if (km !== null) {
        document.getElementById('distance_km').value = km;
        document.getElementById('distance_km').readOnly = false; // still editable if driver wants to adjust
    }
    // If no match found, leave distance_km as-is for manual entry.

    updatePricePreview();
}

// Show/hide the "Other" text input when "Lain-Lain" is selected, and re-run distance lookup.
function handleLocationChange(selectEl, otherInputId) {
    const otherInput = document.getElementById(otherInputId);
    if (selectEl.value === 'Lain-Lain') {
        otherInput.style.display = 'block';
        otherInput.required = true;
    } else {
        otherInput.style.display = 'none';
        otherInput.required = false;
        otherInput.value = '';
    }
    lookupDistance();
}