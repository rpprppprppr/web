<?php
    define('TEMPLATES_DIR', 'templates/');
    define('LAYOUTS_DIR', 'layouts/');

    $page = 'index';
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }
    $params = [];

    switch ($page) {
        case 'index':
            $params['title'] = 'Главная';
            $params['test'] = 'ПРОВЕРКА';
            break;

        case 'catalog':
            $params['title'] = 'Каталог';
            $params['catalog'] = getCatalog();
            break;

        case 'about':
            $params['title'] = 'О нас';
            $params['phone'] = '+7 495 12-23-12';
            break;

        case 'apicatalog':
            echo json_encode(getCatalog(), JSON_UNESCAPED_UNICODE);
            die();

        default:
            echo "404";
            die();
    }

    function getCatalog() {
        return [
            ['name' => 'Яблоко', 'price' => 24, 'image' => 'apple.png'],
            ['name' => 'Банан', 'price' => 1, 'image' => 'banana.png'],
            ['name' => 'Апельсин', 'price' => 12, 'image' => 'orange.png'],
        ];
    }

    function getMenu() {
        return [
            ['title' => 'Главная', 'link' => '/engine1/index.php'],
            [
                'title' => 'Каталог',
                'link' => '/engine1/index.php?page=catalog',
                'children' => [
                    ['title' => 'Фрукты', 'link' => '/engine1/index.php?page=catalog&category=fruits'],
                    ['title' => 'Овощи', 'link' => '/engine1/index.php?page=catalog&category=vegetables'],
                ]
            ],
            ['title' => 'О нас', 'link' => '/engine1/index.php?page=about'],
        ];
    }

    function render($page, $params = []) {
        return renderTemplate(LAYOUTS_DIR . 'main', [
            'title' => $params['title'],
            'menu' => renderTemplate('menu', ['menus' => getMenu()]),
            'content' => renderTemplate($page, $params)
        ]);
    }

    function renderTemplate($page, $params = []) {
        extract($params);
        ob_start();
        include TEMPLATES_DIR . $page . ".php";
        return ob_get_clean();
    }

    echo render($page, $params);
?>