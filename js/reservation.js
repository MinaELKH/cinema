// document.addEventListener("DOMContentLoaded", function () {
//    // fetchSeances();
//    fetchFilms() ; 
// });

// const token = localStorage.getItem("token");


// function fetchFilms() {
//     fetch('http://127.0.0.1:8000/api/films', {
//         headers: {
//             "Authorization": `Bearer ${token}`,
//             "Content-Type": "application/json",
//         }
//     })
//     .then(response => response.json())
//     .then(films => {
//         const filmsContainer = document.getElementById('films');
//         filmsContainer.innerHTML = ''; // Vide la liste avant de la remplir

//         films.forEach(film => {
//             const filmElement = document.createElement('div');
//             filmElement.classList.add('film');
//             filmElement.innerHTML = `
//                 <h3>${film.titre}</h3>
//                 <p>${film.description}</p>
//                 <img src="http://127.0.0.1:8000/storage/films/${film.image}" />
//                 <button class="detailSeance-btn" data-id="${film.id}">Seances</button>
               
//             `;
//             filmsContainer.appendChild(filmElement);
//         });

     
//         const DetailButtons = document.querySelectorAll('.detailSeance-btn');
//         DetailButtons.forEach(button => {
//             button.addEventListener('click', function () {
//                 const filmId = button.getAttribute('data-id');
//                 showSeance(filmId);
//             });
//         });
        
//     })
//     .catch(error => console.error('Erreur lors du chargement des films:', error));
// }

// function showSeance(filmId){
//     // Redirection vers la page des séances avec film_id comme paramètre
//     window.location.href = `seances.html?film_id=${filmId}`;
// }


// function choisirSiegeEtReserver(seanceId) {
//     const siegeId = prompt("Entrez l'ID du siège que vous souhaitez réserver :");
//     if (siegeId) {
//         reserver(seanceId, siegeId);
//     }
// }

// function reserver(seanceId, siegeId) {
//     fetch("http://127.0.0.1:8000/api/reservations", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "Authorization": `Bearer ${token}`,
//         },
//         body: JSON.stringify({
//             seance_id: seanceId,
//             siege_id: siegeId
//         })
//     })
//     .then(response => {
//         if (!response.ok) {
//             return response.json().then(err => { throw err; });
//         }
//         return response.json();
//     })
//     .then(data => {
//         alert("Réservation effectuée avec succès !");
//         console.log(data);
//     })
//     .catch(error => {
//         console.error("Erreur lors de la réservation :", error);
//         alert("Erreur : " + (error.message || "Impossible de réserver."));
//     });
// }
