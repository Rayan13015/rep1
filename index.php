<!DOCTYPE html>
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Recherche Étudiants</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        margin: 0;
        padding: 20px;
    }
    form {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }
    label {
        display: block;
        margin-top: 10px;
    }
    input[type="text"], input[type="number"], select {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    button {
        margin-top: 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }
    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    table th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend><strong>Recherche Étudiants</strong></legend>
            <label>Ville :</label>
            <input type="text" name="ville" placeholder="Ex : Paris" />
            <label>Identifiant (matricule) minimum :</label>
            <input type="number" step="1" name="id_client" placeholder="Ex : 100" />
            <button type="submit">Rechercher</button>
        </fieldset>
    </form>

    <?php
    if (isset($_POST['ville']) || isset($_POST['id_client'])) {
        $ville = strtolower($_POST['ville'] ?? '');
        $id_client = $_POST['id_client'] ?? 0;

        include("connexion.php");
        $idcom = connexpdo('magasin', 'myparam');

        $reqprep = $idcom->prepare(
            "SELECT prenom, nom, matricule 
             FROM etudiants 
             WHERE lower(ville) LIKE :ville 
             AND matricule >= :id_client"
        );

        $reqprep->bindValue(':ville', "%$ville%", PDO::PARAM_STR);
        $reqprep->bindValue(':id_client', $id_client, PDO::PARAM_INT);
        $reqprep->execute();

        $results = $reqprep->fetchAll(PDO::FETCH_ASSOC);
        echo "<div><h3>Résultats trouvés : " . count($results) . "</h3></div>";

        if ($results) {
            echo "<table><thead><tr><th>Prénom</th><th>Nom</th><th>Matricule</th></tr></thead><tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['prenom']) . "</td>
                        <td>" . htmlspecialchars($row['nom']) . "</td>
                        <td>" . htmlspecialchars($row['matricule']) . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>Aucun étudiant ne correspond à votre recherche.</p>";
        }

        $idcom = null;
    }
    ?>
</body>
</html>
