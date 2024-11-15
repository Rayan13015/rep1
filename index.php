<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche Personne</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        input[type="text"], button {
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f4f4f4;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recherche Personne</h1>
        <form method="post" action="">
            <label for="search">Rechercher par nom, prénom, matricule ou ville :</label>
            <input type="text" id="search" name="search" placeholder="Entrez un critère..." required>
            <button type="submit">Rechercher</button>
        </form>
        
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["search"])) {
            // Récupération du critère
            $search = strtolower(trim($_POST["search"]));

            // Inclusion du fichier de connexion
            include("connexion.php");
            $idcom = connexpdo('magasin', 'myparam');

            // Préparation de la requête
            $reqprep = $idcom->prepare("
                SELECT nom, prenom, matricule, ville
                FROM client
                WHERE lower(nom) LIKE :search
                   OR lower(prenom) LIKE :search
                   OR lower(ville) LIKE :search
                   OR matricule LIKE :search
            ");

            // Liaison des paramètres
            $reqprep->bindValue(':search', "%$search%", PDO::PARAM_STR);
            $reqprep->execute();

            // Affichage des résultats
            $results = $reqprep->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Matricule</th>
                            <th>Ville</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                foreach ($results as $row) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['nom']) . "</td>
                            <td>" . htmlspecialchars($row['prenom']) . "</td>
                            <td>" . htmlspecialchars($row['matricule']) . "</td>
                            <td>" . htmlspecialchars($row['ville']) . "</td>
                          </tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>Aucun résultat trouvé pour le critère recherché.</p>";
            }

            $reqprep->closeCursor();
            $idcom = null;
        }
        ?>
    </div>
</body>
</html>
