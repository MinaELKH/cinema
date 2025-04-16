document.addEventListener("DOMContentLoaded", () => {
    const salleForm = document.getElementById("salle-form");
    const formTitle = document.getElementById("form-title");
    const salleIdField = document.getElementById("salle-id");

    const API_URL = 'http://127.0.0.1:8000/api/salles';

    const token = localStorage.getItem("token");

    const authHeaders = {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
    };

    function fetchSalles() {
        fetch(API_URL, { headers: authHeaders })
            .then(res => res.json())
            .then(salles => {
                const container = document.getElementById("salles");
                container.innerHTML = "";
                salles.forEach(salle => {
                    const div = document.createElement("div");
                    div.className = "salle-card";
                    div.innerHTML = `
                        <h3>${salle.nom}</h3>
                        <p>Capacité : ${salle.capacite}</p>
                        <p>Type : ${salle.type}</p>
                        <button class="edit-btn" data-id="${salle.id}">Modifier</button>
                        <button class="delete-btn" data-id="${salle.id}">Supprimer</button>
                    `;
                    container.appendChild(div);
                });

                document.querySelectorAll(".edit-btn").forEach(btn =>
                    btn.addEventListener("click", () => editSalle(btn.dataset.id))
                );

                document.querySelectorAll(".delete-btn").forEach(btn =>
                    btn.addEventListener("click", () => deleteSalle(btn.dataset.id))
                );
            })
            .catch(err => console.error("Erreur chargement salles :", err));
    }

    salleForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const id = salleIdField.value;
        const nom = document.getElementById("nom").value;
        const capacite = document.getElementById("capacite").value;
        const type = document.getElementById("type").value;

        const data = { nom, capacite, type };

        const url = id ? `${API_URL}/${id}` : API_URL;
        const method = id ? "PUT" : "POST";

        fetch(url, {
            method: method,
            headers: authHeaders,
            body: JSON.stringify(data),
        })
            .then(res => res.json())
            .then(() => {
                salleForm.reset();
                salleIdField.value = "";
                formTitle.textContent = "Ajouter une Nouvelle Salle";
                fetchSalles();
            })
            .catch(err => console.error("Erreur enregistrement salle :", err));
    });

    function editSalle(id) {
        fetch(`${API_URL}/${id}`, { headers: authHeaders })
            .then(res => res.json())
            .then(salle => {
                salleIdField.value = salle.id;
                document.getElementById("nom").value = salle.nom;
                document.getElementById("capacite").value = salle.capacite;
                document.getElementById("type").value = salle.type;

                formTitle.textContent = "Modifier Salle";
            })
            .catch(err => console.error("Erreur chargement salle :", err));
    }

    function deleteSalle(id) {
        if (!confirm("Voulez-vous supprimer cette salle ?")) return;

        fetch(`${API_URL}/${id}`, {
            method: "DELETE",
            headers: authHeaders,
        })
            .then(() => fetchSalles())
            .catch(err => console.error("Erreur suppression salle :", err));
    }

    fetchSalles();
});
