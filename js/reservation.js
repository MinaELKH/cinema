document.addEventListener("DOMContentLoaded", function () {
    fetchSeances();
});

const token = localStorage.getItem("token");

function fetchSeances() {
    fetch('http://127.0.0.1:8000/api/seances/films')
        .then(response => response.json())
        .then(seances => {
            const filmsContainer = document.getElementById('films'); // Utilise la même div
            filmsContainer.innerHTML = "";

            seances.forEach(seance => {
                const seanceElement = document.createElement('li');
                seanceElement.classList.add('film');

                const startTime = new Date(seance.start_time).toLocaleString();

                seanceElement.innerHTML = `
                    <h3 class="text-xl font-semibold">${seance.titre}</h3>
                    <p class="text-gray-600">${seance.description}</p>
                    <img src="http://127.0.0.1:8000/storage/films/${seance.image}" alt="${seance.titre}" class="w-52 my-2">
                    <p><strong>Salle :</strong> ${seance.nom} (${seance.type})</p>
                    <p><strong>Date :</strong> ${startTime}</p>
                    <p><strong>Langue :</strong> ${seance.langue}</p>
                    <p><strong>Prix :</strong> ${seance.prix} DH</p>
                    <button class="reserve-btn bg-pink-500 text-white px-4 py-2 mt-2 rounded" data-seance-id="${seance.id}">Réserver</button>
                `;
                filmsContainer.appendChild(seanceElement);
            });

            const reserveButtons = document.querySelectorAll('.reserve-btn');
            reserveButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const seanceId = button.getAttribute('data-seance-id');
                    choisirSiegeEtReserver(seanceId);
                });
            });
        })
        .catch(error => {
            console.error("Erreur lors du chargement des séances :", error);
        });
}

function choisirSiegeEtReserver(seanceId) {
    const siegeId = prompt("Entrez l'ID du siège que vous souhaitez réserver :");
    if (siegeId) {
        reserver(seanceId, siegeId);
    }
}

function reserver(seanceId, siegeId) {
    fetch("http://127.0.0.1:8000/api/reservations", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${token}`,
        },
        body: JSON.stringify({
            seance_id: seanceId,
            siege_id: siegeId
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        alert("Réservation effectuée avec succès !");
        console.log(data);
    })
    .catch(error => {
        console.error("Erreur lors de la réservation :", error);
        alert("Erreur : " + (error.message || "Impossible de réserver."));
    });
}
