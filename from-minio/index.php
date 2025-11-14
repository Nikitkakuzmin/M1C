<?php
// from-minio/index.php

$config = require __DIR__ . '/../config.php';

$itemCode = isset($_GET['item_code']) ? trim($_GET['item_code']) : '';
$error = '';
$imageUrl = null;

if ($itemCode !== '') {
    // Собираем имя файла по шаблону, заданному в config.php
    // Например: {item_code}-w.webp
    $filename = str_replace('{item_code}', $itemCode, $config['minio_filename_pattern']);

    // Строим полный URL:
    // http://endpoint/bucket/prefix/filename
    $imageUrl = rtrim($config['minio_endpoint'], '/')
        . '/' . trim($config['minio_bucket'], '/')
        . '/' . trim($config['minio_prefix'], '/')
        . '/' . $filename;

    // По желанию можно попробовать сделать HEAD-запрос и проверить, что он существует.
    // Если не хочется дергать MinIO - можно пропустить этот блок.
    /*
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $imageUrl,
        CURLOPT_NOBODY         => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        $error = 'Файл в MinIO не найден. Код ответа: ' . $httpCode;
        $imageUrl = null;
    }
    */
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Фото из MinIO</title>
</head>
<body>
    <h1>Фото из MinIO</h1>

    <form method="get">
        <label>
            Код изделия (item_code):
            <input type="text" name="item_code" value="<?= htmlspecialchars($itemCode, ENT_QUOTES, 'UTF-8') ?>">
        </label>
        <button type="submit">Показать</button>
    </form>

    <?php if ($error): ?>
        <div style="color:red; margin-top:10px;">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if ($imageUrl && !$error): ?>
        <h2>Результат для <?= htmlspecialchars($itemCode, ENT_QUOTES, 'UTF-8') ?></h2>
        <img src="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>" alt="Фото изделия" style="max-width:400px; display:block; margin-top:10px;">
        <p>URL: <?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</body>
</html>
