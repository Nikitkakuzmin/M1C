<?php
return [
    // 1C endpoint для картинок
    'onec_url'      => 'http://srv-test02/hs/JP/JewPhoto/',

    // MinIO
    'minio_endpoint' => 'http://10.20.20.37:9101',
    'minio_bucket'   => 'photo2',
    'minio_prefix'   => 'test2/2023-06-15', // для первого теста можно зафиксировать дату
    'minio_filename_pattern' => '{item_code}-w.webp',
];
