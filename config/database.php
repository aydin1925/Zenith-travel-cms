<?php
declare(strict_types=1);

/*
| Veritabani ayarlari .env'den okunur.
| Kod tabaninda hicbir yerde sifre gecmesin.
*/

return [
    'host'     => env('DB_HOST', 'localhost'),
    'database' => env('DB_NAME', 'zenith_db'),
    'username' => env('DB_USER', 'root'),
    'password' => env('DB_PASS', ''),
    'charset'  => env('DB_CHARSET', 'utf8mb4'),
];
