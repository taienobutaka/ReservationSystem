<?php

require 'vendor/autoload.php';

use SimpleSoftwareIO\QrCode\Generator;

$qrcode = new Generator;

header('Content-Type: image/png');
echo $qrcode->format('png')->size(200)->generate('https://www.example.com');