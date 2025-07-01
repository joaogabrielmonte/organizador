<?php
define('ROTINAS_FILE', __DIR__ . '/../data/rotinas.json');

function carregarRotinas() {
    if (!file_exists(ROTINAS_FILE)) {
        return [];
    }
    return json_decode(file_get_contents(ROTINAS_FILE), true) ?? [];
}

function salvarRotinas($rotinas) {
    file_put_contents(ROTINAS_FILE, json_encode($rotinas, JSON_PRETTY_PRINT));
}
