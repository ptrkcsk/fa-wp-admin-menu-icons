<?php

namespace Fawpami;

require_once __DIR__ . '/../src/Fawpami.php';

$faVersion = Fawpami::FA_VERSION;

$file = file_get_contents(
    "https://raw.githubusercontent.com/FortAwesome/Font-Awesome/{$faVersion}/advanced-options/metadata/shims.json"
);

file_put_contents(__DIR__ . '/../src/fa-shims.json', $file);