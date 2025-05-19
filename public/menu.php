<?php
    // Подключение к БД
    $db = mysqli_connect("MySQL-8.2", "kondrenko", "123123", "web");
    if (!$db) {
        die("Ошибка подключения: " . mysqli_connect_error());
    }

    // Получения пунктов меню рекурсивно
    function getMenuItems($parent_id = null)
    {
        global $db;
        $parentCondition = is_null($parent_id) ? "IS NULL" : "= $parent_id";
        $query = "SELECT id, name FROM menu_items WHERE parent_id $parentCondition";
        $result = mysqli_query($db, $query);

        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $children = getMenuItems($row['id']);
            $items[] = [
                'name' => $row['name'],
                'hasChildren' => !empty($children),
                'items' => $children
            ];
        }
        return $items;
    }

    // Рекурсивная функция генерации HTML-дерева
    function renderMenu($data)
    {
        $html = '<div class="list-item" data-parent>';
        $html .= '<div class="list-item__inner">';
        $html .= '<div class="list-item__arrow-container">';
        $html .= $data['hasChildren'] ? '<img class="list-item__arrow" src="img/chevron-down.png" alt="chevron-down" data-open>' : '';
        $html .= '</div>';
        $html .= '<img class="list-item__folder" src="img/folder.png" alt="folder">';
        $html .= '<span class="list-item__text">' . htmlspecialchars($data['name']) . '</span>';
        $html .= '</div>';

        if ($data['hasChildren']) {
            $html .= '<div class="list-item__items">';
            foreach ($data['items'] as $child) {
                $html .= renderMenu($child);
            }
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }

    $menuItems = getMenuItems(null);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="list-items" class="list-items">
        <?php
            foreach ($menuItems as $item) {
                echo renderMenu($item);
            }
        ?>
    </div>
    <script src="script.js"></script>
</body>
</html>