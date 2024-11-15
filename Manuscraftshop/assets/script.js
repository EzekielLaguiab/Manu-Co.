
    function showSection(sectionId) {
        // Hide all sections
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => section.classList.remove('active'));

        // Show the selected section
        document.getElementById(sectionId).classList.add('active');
    }

    // On page load, check if there's a hash in the URL and show the corresponding section
    document.addEventListener('DOMContentLoaded', function () {
        const hash = window.location.hash.substring(1); // Get hash from URL, remove '#'
        if (hash) {
            showSection(hash); // Show the section corresponding to the hash
        }
    });

    function togglePassword(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordField.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
   // Define Luzon-specific province-city-barangay mappings
   const provinceCityData = {
    "Metro Manila": ["Quezon City", "Manila", "Makati", "Taguig", "Pasig", "Parañaque"],
    "Ilocos Norte": ["Laoag", "Batac", "Paoay", "San Nicolas"],
    "Ilocos Sur": ["Vigan", "Candon", "Narvacan", "Santa Maria"],
    "Pangasinan": ["Dagupan", "San Carlos", "Urdaneta", "Alaminos", "Lingayen"],
    "La Union": ["San Fernando", "Bauang", "Agoo", "Rosario"],
    "Cagayan": ["Tuguegarao", "Aparri", "Sanchez-Mira", "Baggao"],
    "Isabela": ["Ilagan", "Cauayan", "Santiago", "Echague"],
    "Nueva Ecija": ["Cabanatuan", "Gapan", "San Jose", "Palayan"],
    "Pampanga": ["San Fernando", "Angeles City", "Mabalacat", "Porac"],
    "Tarlac": ["Tarlac City", "Concepcion", "Capas", "Bamban"],
    "Bulacan": ["Malolos", "Meycauayan", "San Jose del Monte", "Bocaue", "Santa Maria"],
    "Cavite": ["Bacoor", "Dasmariñas", "Imus", "Tagaytay", "Trece Martires"],
    "Batangas": ["Batangas City", "Lipa City", "Tanauan City", "Nasugbu", "San Juan"],
    "Laguna": ["Santa Rosa", "Calamba", "San Pedro", "Biñan", "Los Baños"],
    "Rizal": ["Antipolo", "Cainta", "Taytay", "Binangonan", "Angono"],
    "Quezon": ["Lucena", "Tayabas", "Sariaya", "Candelaria", "Tiaong"],
    "Bataan": ["Balanga", "Dinalupihan", "Orani", "Mariveles"],
    "Zambales": ["Olongapo", "Subic", "San Narciso", "Iba"]
};

const cityBarangayData = {
    // Metro Manila
    "Quezon City": ["Barangay Commonwealth", "Barangay Batasan Hills", "Barangay Holy Spirit"],
    "Manila": ["Barangay 659", "Barangay 660", "Barangay 661", "Barangay Ermita", "Barangay Intramuros"],
    "Makati": ["Barangay Bel-Air", "Barangay Poblacion", "Barangay San Lorenzo"],
    "Taguig": ["Barangay Fort Bonifacio", "Barangay Western Bicutan", "Barangay Tanyag"],

    // Ilocos Norte
    "Laoag": ["Barangay 1", "Barangay 2", "Barangay 3"],
    "Batac": ["Barangay Aglipay", "Barangay Baay", "Barangay Bungon"],
    
    // Ilocos Sur
    "Vigan": ["Barangay Ayusan Norte", "Barangay Ayusan Sur", "Barangay Tamag"],
    "Candon": ["Barangay Calaoa-an", "Barangay San Nicolas", "Barangay Talogtog"],
    
    // Pangasinan
    "Dagupan": ["Barangay Pantal", "Barangay Bonuan Gueset", "Barangay Tebeng"],
    "San Carlos": ["Barangay Bacnar", "Barangay Taloy", "Barangay Agdao"],
    
    // La Union
    "San Fernando": ["Barangay Biday", "Barangay Lingsat", "Barangay Dalumpinas Oeste"],
    
    // Cagayan
    "Tuguegarao": ["Barangay Cataggaman Nuevo", "Barangay Pallua Norte", "Barangay Ugac Norte"],
    
    // Isabela
    "Ilagan": ["Barangay Alibagu", "Barangay Bagumbayan", "Barangay Baligatan"],
    
    // Nueva Ecija
    "Cabanatuan": ["Barangay Aduas Centro", "Barangay San Josef Sur", "Barangay Kapitan Pepe"],
    
    // Pampanga
    "San Fernando": ["Barangay Dolores", "Barangay Sindalan", "Barangay San Agustin"],
    "Angeles City": ["Barangay Balibago", "Barangay Cutcut", "Barangay Pampang"],

    // Tarlac
    "Tarlac City": ["Barangay San Vicente", "Barangay Tibag", "Barangay Matatalaib"],

    // Bulacan
    "Malolos": ["Barangay Santo Rosario", "Barangay Atlag", "Barangay Mojon"],

    // Cavite
    "Bacoor": ["Barangay Talaba", "Barangay Zapote", "Barangay Molino II"],
    "Dasmariñas": ["Barangay San Agustin", "Barangay Salawag", "Barangay Paliparan"],
    
    // Batangas
    "Batangas City": ["Barangay Poblacion", "Barangay Sta. Clara", "Barangay Bolbok"],
    
    // Laguna
    "Santa Rosa": ["Barangay Balibago", "Barangay Kanluran", "Barangay Aplaya"],
    
    // Rizal
    "Antipolo": ["Barangay Cupang", "Barangay Dalig", "Barangay Inarawan"],

    // Quezon
    "Lucena": ["Barangay Dalahican", "Barangay Ibabang Dupay", "Barangay Gulang-Gulang"],

    // Bataan
    "Balanga": ["Barangay Poblacion", "Barangay Tuyo", "Barangay Cupang Proper"],

    // Zambales
    "Olongapo": ["Barangay Barretto", "Barangay Kalaklan", "Barangay Gordon Heights"]
};

function populateProvinces() {
    const provinceSelect = document.getElementById("province");
    provinceSelect.innerHTML = `<option value="">Select Province</option>`;
    
    Object.keys(provinceCityData).forEach(province => {
        provinceSelect.innerHTML += `<option value="${province}">${province}</option>`;
    });
}

function populateCities() {
    const province = document.getElementById("province").value;
    const citySelect = document.getElementById("city");
    citySelect.innerHTML = `<option value="">Select Town / City</option>`;
    
    if (provinceCityData[province]) {
        provinceCityData[province].forEach(city => {
            citySelect.innerHTML += `<option value="${city}">${city}</option>`;
        });
    }
    
    // Reset barangay dropdown
    document.getElementById("Barangay").innerHTML = `<option value="">Select Barangay</option>`;
}

function populateBarangays() {
    const city = document.getElementById("city").value;
    const barangaySelect = document.getElementById("Barangay");
    barangaySelect.innerHTML = `<option value="">Select Barangay</option>`;
    
    if (cityBarangayData[city]) {
        cityBarangayData[city].forEach(barangay => {
            barangaySelect.innerHTML += `<option value="${barangay}">${barangay}</option>`;
        });
    }
}

// Initialize provinces on page load
document.addEventListener("DOMContentLoaded", populateProvinces);