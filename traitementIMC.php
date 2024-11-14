

<?php

if (isset($_POST['poids']) && isset($_POST['taille'])) {

    // On sécurise les données

    $poids = (float) htmlspecialchars($_POST['poids']);

    $taille = (float) htmlspecialchars($_POST['taille']);


    if ($poids > 0 && $taille > 0) {

        // Calcul de l'IMC

        $imc = $poids / ($taille * $taille);

        echo 'Votre IMC est de ' . number_format($imc, 2) . '<br>';


        // Interprétation de l'IMC selon l'OMS

        echo '<h2>Indice de masse corporelle (IMC) - Interprétation</h2>';

        if ($imc < 18.5) {

            echo 'Insuffisance pondérale (maigreur)';

        } elseif ($imc >= 18.5 && $imc < 25) {

            echo 'Corpulence normale';

        } elseif ($imc >= 25 && $imc < 30) {

            echo 'Surpoids';

        } elseif ($imc >= 30 && $imc < 35) {

            echo 'Obésité modérée';

        } elseif ($imc >= 35 && $imc < 40) {

            echo 'Obésité sévère';

        } else {

            echo 'Obésité morbide ou massive';

        }

    } else {

        echo 'Veuillez entrer des valeurs positives pour le poids et la taille.';

    }

} else {

    echo 'Formulaire non soumis correctement.';

}

?>





