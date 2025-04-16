<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Réservation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #f4f4f4;
            color: #333;
        }

        .ticket-container {
            background: white;
            border: 2px dashed #888;
            border-radius: 15px;
            padding: 30px;
            width: 80%;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
            color: #d35400;
        }

        .header p {
            font-size: 18px;
            margin: 5px 0;
        }

        .details {
            margin: 20px 0;
            font-size: 18px;
        }

        .details strong {
            display: inline-block;
            width: 150px;
        }

        .footer {
            margin-top: 30px;
            font-size: 16px;
            text-align: center;
            color: #555;
        }

    </style>
</head>
<body>
<div class="ticket-container">
    <div class="header">
        <h1>CinéHall</h1>
        <p>🎟️ Ticket de Réservation</p>
    </div>

    <div class="details">
        <p><strong>Client :</strong> {{ $customer_name }}</p>
        <p><strong>Film :</strong> {{ $Film }}</p>
        <p><strong>Séance :</strong> {{ $Seance }}</p>
        <p><strong>Siège :</strong> {{ $Siege }}</p>
        <p><strong>Prix :</strong> {{ $Prix }} MAD</p>
        <p><strong>Code :</strong> {{ $reservation_code }}</p>
    </div>

    <div class="footer">
        Merci d’avoir réservé avec CinéHall 🎬<br>
        Présentez ce ticket à l'entrée de la salle.<br>
        Bonne séance !
    </div>
</div>
</body>
</html>
