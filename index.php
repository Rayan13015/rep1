<?php
// Inclusion du fichier de connexion
include("connexion.php"); // On suppose que le fichier connexion.php est dans le même dossier
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche Personne</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recherche de Personnes</h1>
        <form method="post" action="">
            <!-- Champ de recherche -->
            <label for="search">Rechercher par nom, prénom, matricule ou ville :</label>
            <input type="text" id="search" name="search" placeholder="Entrez un critère..." required>
            <button type="submit">Rechercher</button>
        </form>

        <?php
        // Vérification si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Vérifier si le champ de recherche n'est pas vide
            if (!empty($_POST["search"])) {
                $search = trim($_POST["search"]); // Supprimer les espaces en trop

                // Connexion à la base de données
                $idcom = connexpdo('magasin', 'myparam'); // Appel de la fonction connexpdo du fichier connexion.php

                // Préparation de la requête SQL
                $sql = "
                    SELECT nom, prenom, matricule, ville
                    FROM client
                    WHERE lower(nom) LIKE :search
                       OR lower(prenom) LIKE :search
                       OR lower(ville) LIKE :search
                       OR matricule LIKE :search
                ";
                $reqprep = $idcom->prepare($sql);

                // Paramètre pour la recherche avec le wildcard (%)
                $searchParam = '%' . strtolower($search) . '%';
                $reqprep->bindValue(':search', $searchParam, PDO::PARAM_STR);

                // Exécution de la requête
                $reqprep->execute();

                // Récupération des résultats
                $results = $reqprep->fetchAll(PDO::FETCH_ASSOC);

                // Affichage des résultats si disponibles
                if (!empty($results)) {
                    echo "<table>";
                    echo "<tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Matricule</th>
                            <th>Ville</th>
                          </tr>";
                    foreach ($results as $row) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['nom']) . "</td>
                                <td>" . htmlspecialchars($row['prenom']) . "</td>
                                <td>" . htmlspecialchars($row['matricule']) . "</td>
                                <td>" . htmlspecialchars($row['ville']) . "</td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    // Aucun résultat trouvé
                    echo "<p>Aucun résultat trouvé pour la recherche : <strong>" . htmlspecialchars($search) . "</strong></p>";
                }

                // Fermeture de la requête et de la connexion
                $reqprep->closeCursor();
                $idcom = null;
            } else {
                // Message d'erreur si le champ est vide (ne devrait pas arriver à cause du "required" en HTML)
                echo "<p>Veuillez entrer un critère de recherche.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
