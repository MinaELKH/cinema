// Fonction pour récupérer et afficher les films
document.addEventListener("DOMContentLoaded", function() {
    fetch('http://127.0.0.1:8000/api/films')  // Remplace par ton URL d'API si nécessaire
    .then(response => response.json())
    .then(films => {
        const filmsContainer = document.getElementById('films-container');
        
        films.forEach(film => {
            // Créer un élément pour chaque film
            const filmElement = document.createElement('div');
            filmElement.classList.add('film');
            filmElement.innerHTML = `
                <h3>${film.titre}</h3>
                <p>${film.description}</p>
                <img src="${film.image_url}" alt="${film.title}" />
            `;
            
            // Ajouter le film à la page
            filmsContainer.appendChild(filmElement);
        });
    })
    .catch(error => {
        console.error('Erreur lors du chargement des films:', error);
    });
});
