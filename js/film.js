document.addEventListener("DOMContentLoaded", function() {
    const filmForm = document.getElementById("film-form");
    const formTitle = document.getElementById("form-title");
    const filmIdField = document.getElementById("film-id");

    // Récupérer le token d'authentification
    const token = localStorage.getItem("token");

    // Fonction pour récupérer les films
    function fetchFilms() {
        fetch('http://127.0.0.1:8000/api/films', {
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json",
            }
        })
        .then(response => response.json())
        .then(films => {
            const filmsContainer = document.getElementById('films');
            filmsContainer.innerHTML = ''; // Vide la liste avant de la remplir

            films.forEach(film => {
                const filmElement = document.createElement('div');
                filmElement.classList.add('film');
                filmElement.innerHTML = `
                    <h3>${film.titre}</h3>
                    <p>${film.description}</p>
                    <img src="http://127.0.0.1:8000/storage/films/${film.image}" />
                    <button class="edit-btn" data-id="${film.id}">Modifier</button>
                    <button class="delete-btn" data-id="${film.id}">Supprimer</button>
                `;
                filmsContainer.appendChild(filmElement);
            });

            // Attacher les événements de suppression après l'ajout des films
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filmId = button.getAttribute('data-id');
                    deleteFilm(filmId);
                });
            });

            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filmId = button.getAttribute('data-id');
                    editFilm(filmId);
                });
            });
        })
        .catch(error => console.error('Erreur lors du chargement des films:', error));
    }

    // Fonction pour ajouter ou modifier un film
    filmForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const filmId = filmIdField.value;
        const method = filmId ? "POST" : "POST"; // on utilise POST même pour les updates via FormData

        const formData = new FormData();
        formData.append("titre", document.getElementById("titre").value);
        formData.append("description", document.getElementById("description").value);
        formData.append("duree", document.getElementById("duree").value);
        formData.append("genre", document.getElementById("genre").value);
        formData.append("age_minimum", document.getElementById("age_minimum").value);

        const imageFile = filmForm.querySelector('input[type="file"]').files[0];
        if (imageFile) {
            formData.append("image", imageFile);
        }

        const url = filmId
            ? `http://127.0.0.1:8000/api/films/${filmId}?_method=PUT`
            : `http://127.0.0.1:8000/api/films`;

        fetch(url, {
            method: "POST", // même pour update, car on utilise _method=PUT
            headers: {
                "Authorization": `Bearer ${token}`, // Ajout du token ici
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Film enregistré :", data);
            fetchFilms(); // Recharger la liste
            filmForm.reset(); // Réinitialiser le formulaire
            formTitle.textContent = "Ajouter un Nouveau Film";
            filmIdField.value = '';
        })
        .catch(error => console.error("Erreur fetch :", error));
    });

    // Fonction pour éditer un film
    function editFilm(id) {
        fetch(`http://127.0.0.1:8000/api/films/${id}`, {
            headers: {
                "Authorization": `Bearer ${token}`, // Ajout du token ici
            }
        })
        .then(response => response.json())
        .then(film => {
            formTitle.textContent = "Modifier le Film";
            filmIdField.value = film.id;
            filmForm.titre.value = film.titre;
            filmForm.description.value = film.description;
            filmForm.duree.value = film.duree;
            filmForm.genre.value = film.genre;
            filmForm.age_minimum.value = film.age_minimum;

            const imagePreview = document.getElementById("image-preview");
            if (imagePreview) {
                imagePreview.src = `http://127.0.0.1:8000/storage/films/${film.image}`;
                imagePreview.alt = "Image actuelle du film";
            }
        })
        .catch(error => console.error('Erreur lors de la récupération du film à modifier:', error));
    }

    // Fonction pour supprimer un film
    function deleteFilm(id) {
        if (confirm("Voulez-vous vraiment supprimer ce film ?")) {
            fetch(`http://127.0.0.1:8000/api/films/${id}`, {
                method: "DELETE",
                headers: {
                    "Authorization": `Bearer ${token}`, // Ajout du token ici
                },
            })
            .then(response => response.json())
            .then(() => {
                fetchFilms(); // Recharger la liste après suppression
            })
            .catch(error => console.error("Erreur lors de la suppression du film:", error));
        }
    }

    // Charger la liste des films au démarrage
    fetchFilms();  // Cette ligne appelle la fonction fetchFilms au chargement de la page
});
