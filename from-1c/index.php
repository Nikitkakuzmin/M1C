<?php
// from-1c/index.php

$config = require __DIR__ . '/../config.php';

$itemCode = isset($_GET['item_code']) ? trim($_GET['item_code']) : '';

$error = '';
$imageDataUri = null;

if ($itemCode !== '') {
    // Формируем URL: base /hs/JP/JewPhoto/?JewelCode=XXX
    $url = rtrim($config['onec_url'], '/'); // на случай, если в config нет слэша
    $url .= '?JewelCode=' . urlencode($itemCode);

    // Готовим запрос в 1С через cURL
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERPWD        => $config['onec_login'] . ':' . $config['onec_password'],
        CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
        CURLOPT_HEADER         => false,
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = 'Ошибка запроса к 1С: ' . curl_error($ch);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            $error = '1С вернул статус ' . $httpCode;
        } else {
            // Тут бинарная картинка
            // Для простоты считаем, что это JPEG (можно поменять на image/png)
            $mime = 'image/jpeg';
            $imageDataUri = 'data:' . $mime . ';base64,' . base64_encode($response);
        }
    }

    curl_close($ch);
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Фото из 1С по JewelCode</title>
</head>
<body>
    <h1>Фото из 1С</h1>

    <form method="get">
        <label>
            Код изделия (item_code / JewelCode):
            <input type="text" name="item_code" value="<?= htmlspecialchars($itemCode, ENT_QUOTES, 'UTF-8') ?>">
        </label>
        <button type="submit">Показать</button>
    </form>

    <?php if ($error): ?>
        <div style="color:red; margin-top:10px;">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if ($imageDataUri && !$error): ?>
        <h2>Результат для <?= htmlspecialchars($itemCode, ENT_QUOTES, 'UTF-8') ?></h2>
        <img src="<?= $imageDataUri ?>" alt="Фото изделия" style="max-width:400px; display:block; margin-top:10px;">
    <?php endif; ?>
</body>
</html>
