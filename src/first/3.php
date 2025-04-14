<?php
    $template = file_get_contents("template.html");

    $replacements = [
        "{{title}}" => "Главная страница",
        "{{header}}" => "Добро пожаловать на сайт!",
        "{{year}}" => date("Y")
    ];

    $page = str_replace(array_keys($replacements), array_values($replacements), $template);

    echo $page;
?>