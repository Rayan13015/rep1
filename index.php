
<?php
// Connexion à la base de données
include("connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche Étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Rechercher un étudiant</h2>
        <form method="post">
            <input type="text" name="search" placeholder="Entrez un critère..." required>
            <button type="submit">Rechercher</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération de la saisie
            $search = trim($_POST["search"]);

            // Connexion
            $db = connexpdo('formulaire', 'myparam');

            // Requête avec joker pour la recherche
            $query = $db->prepare("
                SELECT matricule, nom_etud, prenom_etud, adresse
                FROM etudiants
                WHERE LOWER(nom_etud) LIKE :critere
                   OR LOWER(prenom_etud) LIKE :critere
                   OR LOWER(adresse) LIKE :critere
                   OR matricule LIKE :critere
            ");
            $query->execute([':critere' => '%' . strtolower($search) . '%']);

            // Affichage des résultats
            $resultats = $query->fetchAll(PDO::FETCH_ASSOC);
            if ($resultats) {
                echo "<table>";
                echo "<tr><th>Matricule</th><th>Nom</th><th>Prénom</th><th>Adresse</th></tr>";
                foreach ($resultats as $row) {
                    echo "<tr>
                            <td>{$row['matricule']}</td>
                            <td>{$row['nom_etud']}</td>
                            <td>{$row['prenom_etud']}</td>
                            <td>{$row['adresse']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Aucun résultat pour « " . htmlspecialchars($search) . " »</p>";
            }
        }
        ?>
    </div>
</body>
</html>
