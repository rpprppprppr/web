<?php
    include_once 'ImageResize.php';

    use \Gumlet\ImageResize;

    $messages = [
        'ok' => 'Файл загружен',
        'error' => 'Ошибка загрузки',
    ];

    $message = "";
    $image = new ImageResize('upload/123.png');

    $image->resizeToWidth(300);
    $image->save('upload/small/image34.jpg');

    if (!empty($_FILES)) {
        $path = "upload/" . $_FILES['myfile']['name'];

        //Проверить на безопасность

        if (move_uploaded_file($_FILES['myfile']['tmp_name'], $path)) {
            $message =  "ok";
        } else {
            $message =  "error";
        }

            header("Location: index.php?status=$message");
            die();
    }

    if(!empty($_GET['status'])) {
        $message = $messages[$_GET['status']];
    }

    //var_dump(array_slice(scandir('upload'), 2));
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Index.php</title>
    </head>
    <body>
        <?=$message?><br>
        
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="myfile">
            <input type="submit" value="Загрузить">
        </form>
    </body>
</html>
