<?php
// config.php
// Сюда вписываем реальные URL и логины/пароли

return [
    // 1C endpoint для картинок
    // Должен быть что-то типа: https://your-1c-server/hs/JP/JewPhoto/
    // Важно: с конечным слэшем
    'onec_url'      => 'https://YOUR-1C-SERVER/hs/JP/JewPhoto/',

    // Basic Auth для 1С
    'onec_login'    => 'YOUR_1C_LOGIN',
    'onec_password' => 'YOUR_1C_PASSWORD',

    // MinIO
    // Endpoint твоего MinIO (можно и внутренний, типа http://10.20.20.37:9000)
    'minio_endpoint' => 'http://10.20.20.37:9000',

    // Бакет, куда ты складываешь photo webp
    'minio_bucket'   => 'photo2',

    // Папка / префикс внутри бакета
    // Например, у тебя есть test2/work2/workidt2 — для теста берём test2.
    'minio_prefix'   => 'test2',

    // Шаблон имени файла в MinIO.
    // Например, если твой скрипт кладёт {item_code}-w.webp, то:
    'minio_filename_pattern' => '{item_code}-w.webp',
];
