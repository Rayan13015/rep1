GNU nano 6.2                                                        index.html                                                                  
<!DOCTYPE html>

<html lang="fr">

<head>

    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />

    <link rel="stylesheet" href="style.css" />

    <title>Calculatrice d'IMC en HTML/PHP</title>

</head>


<body>

<div id="bloc_page">

    <header>

        <div id="titre_principal">

            <h1>Calculatrice d'IMC</h1>

        </div>

        <div style="text-align:center;">

            <form name="formulaire" method="post" action="traitement.php">

                <p>Taille (en mètres) : <input name="taille" type="text" ></p>

                <p>Poids (en kg) : <input name="poids" type="text" ></p>

                <input type="submit" value="Calculer l'IMC">

                <input type="reset" value="Effacer"><br>

            </form>

        </div>

    </header>

</div>

</body>

</html>

