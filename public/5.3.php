<?php 
    $template = file_get_contents("template.html");
    $page = str_replace("{{year}}", date("Y"), $template);

    echo $page;
?>