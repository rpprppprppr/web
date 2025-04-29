<?php
    session_start();

    include_once 'logger.php';
    logRequest();

    include_once 'ImageResize.php';
    use Gumlet\ImageResize;

    $bigDir = __DIR__ . '/uploads/big/';
    $smallDir = __DIR__ . '/uploads/small/';
    $message = '';

    if (!file_exists($bigDir)) mkdir($bigDir, 0777, true);
    if (!file_exists($smallDir)) mkdir($smallDir, 0777, true);

    if (!empty($_FILES['image'])) {
        $file = $_FILES['image'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $fileType = mime_content_type($file['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['message'] = "Можно загружать только JPG, PNG или GIF.";
        } elseif ($file['size'] > $maxSize) {
            $_SESSION['message'] = "Размер файла не должен превышать 5 МБ.";
        } else {
            $filename = uniqid() . '_' . basename($file['name']);
            $bigPath = $bigDir . $filename;
            $smallPath = $smallDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $bigPath)) {
                $image = new ImageResize($bigPath);
                $image->resizeToWidth(300);
                $image->save($smallPath);
                $_SESSION['message'] = "Файл успешно загружен!";
            } else {
                $_SESSION['message'] = "Ошибка при загрузке файла.";
            }
        }

        header("Location: index.php");
        exit;
    }

    if (!empty($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }

    $images = array_diff(scandir($smallDir), ['.', '..']);
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>КОТОгалерея</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <?php if ($message): ?>
                <div class="message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form class="upload-form" method="post" enctype="multipart/form-data">
                <label class="file-label">
                    Выбрать файл
                    <input type="file" name="image" accept="image/jpeg,image/png,image/gif" required>
                </label>
                <button type="submit" class="upload-btn">Загрузить</button>
            </form>

            <div class="gallery">
                <?php foreach ($images as $img): ?>
                    <a href="uploads/big/<?= urlencode($img) ?>" target="_blank">
                        <img src="uploads/small/<?= urlencode($img) ?>" alt="">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>