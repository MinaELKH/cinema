// Remplace cette URL par celle de ton API si besoin
const API_BASE_URL = 'http://localhost:8000/api';

// Sélection des éléments
const filmSelect = document.getElementById('film');
const salleSelect = document.getElementById('salle');
const form = document.getElementById('seance-form');

// Charger les films
async function chargerFilms() {
    try {
        const res = await fetch(`${API_BASE_URL}/films`);
        const data = await res.json();

        data.forEach(film => {
            const option = document.createElement('option');
            option.value = film.id;
            option.textContent = film.titre;
            filmSelect.appendChild(option);
        });
    } catch (error) {
        alert('Erreur lors du chargement des films');
        console.error(error);
    }
}

// Charger les salles
async function chargerSalles() {
    try {
        const res = await fetch(`${API_BASE_URL}/salles`);
        const data = await res.json();

        data.forEach(salle => {
            const option = document.createElement('option');
            option.value = salle.id;
            option.textContent = salle.nom;
            salleSelect.appendChild(option);
        });
    } catch (error) {
        alert('Erreur lors du chargement des salles');
        console.error(error);
    }
}

// Soumission du formulaire
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = {
        film_id: parseInt(filmSelect.value),
        salle_id: parseInt(salleSelect.value),
        start_time: document.getElementById('start_time').value,
        session: document.getElementById('session').value,
        langue: document.getElementById('langue').value,
        type_seance: document.getElementById('type_seance').value,
        prix: parseFloat(document.getElementById('prix').value)
    };

    try {
        const res = await fetch(`${API_BASE_URL}/seances`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        if (!res.ok) {
            const err = await res.json();
            alert(`Erreur : ${err.message || 'Une erreur est survenue'}`);
            return;
        }

        alert('Séance ajoutée avec succès !');
        form.reset();
    } catch (error) {
        alert('Erreur lors de l\'ajout de la séance');
        console.error(error);
    }
});

// Appel des fonctions de chargement au chargement de la page
window.addEventListener('DOMContentLoaded', () => {
    chargerFilms();
    chargerSalles();
});
