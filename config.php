<?php
// config.php

return [
    // 1C endpoint для картинок
    // типичный вид: http://10.20.20.37/hs/JP/JewPhoto/ или https://your-1c-server/hs/JP/JewPhoto/
    // ВАЖНО: со слэшем в конце
    'onec_url'      => 'http://YOUR-1C-SERVER/hs/JP/JewPhoto/',

    // MinIO
    'minio_endpoint' => 'http://10.20.20.37:9000',
    'minio_bucket'   => 'photo2',
    'minio_prefix'   => 'test2/2023-06-15', // для теста можно зафиксировать дату
    'minio_filename_pattern' => '{item_code}-w.webp',
];
