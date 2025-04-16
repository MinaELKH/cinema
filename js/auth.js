const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const messageDiv = document.getElementById("message");

const API_URL = "http://127.0.0.1:8000/api";

loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    try {
        const res = await fetch(`${API_URL}/login`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();

        if (res.ok) {
            localStorage.setItem("token", data.token);
            localStorage.setItem("user", JSON.stringify(data.user));
            messageDiv.classList.remove("text-red-500");
            messageDiv.classList.add("text-green-600");
            messageDiv.textContent = "Connexion réussie ✅";

            //redirection 

            if (data.user.role === "admin") {
                window.location.href = "dashboard.html";
            } else if (data.user.role === "spectateur") {
                window.location.href = "films.html";
            } else {
                window.location.href = "index.html"; // rôle inconnu ou visiteur
            }



        } else {
            throw new Error(data.error || "Erreur de connexion");
        }
    } catch (err) {
        messageDiv.classList.remove("text-green-600");
        messageDiv.classList.add("text-red-500");
        messageDiv.textContent = err.message;
    }
});

registerForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const name = document.getElementById("registerName").value;
    const email = document.getElementById("registerEmail").value;
    const password = document.getElementById("registerPassword").value;
    const role = document.getElementById("registerRole").value;

    try {
        const res = await fetch(`${API_URL}/register`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, email, password, role })
        });

        const data = await res.json();

        if (res.ok) {
            localStorage.setItem("token", data.token);
            localStorage.setItem("user", JSON.stringify(data.user));
            messageDiv.classList.remove("text-red-500");
            messageDiv.classList.add("text-green-600");
            messageDiv.textContent = "Inscription réussie ✅";

            window.location.href = "films.html";
        } else {
            throw new Error(data.message || "Erreur d'inscription");
        }
    } catch (err) {
        messageDiv.classList.remove("text-green-600");
        messageDiv.classList.add("text-red-500");
        messageDiv.textContent = err.message;
    }
});
