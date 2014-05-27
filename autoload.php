<?php
function __autoload($_classe /** Nom de la classe dont la définition manque */) {
    // Nom du fichier = nom_de_la_classe.class.php
    $fichier = strToLower($_classe).'.class.php' ;
    // Existe ?
    if (file_exists($fichier))
        // Oui : l'inclure
        require_once($fichier) ;
    // Pour être compatible avec le système de gestion des corrections
    if (file_exists('../' . $fichier))
        // Oui : l'inclure
        require_once($fichier) ;
}