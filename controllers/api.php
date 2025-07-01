<?php
header('Content-Type: application/json');

// Exemplo de API pública
$frase = file_get_contents("https://zenquotes.io/api/random");
echo $frase;
