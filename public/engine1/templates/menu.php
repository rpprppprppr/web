<?php
    function renderMenu($menus) {
        echo '<ul>';
        foreach ($menus as $menu) {
            echo '<li>';
            echo '<a href="' . $menu['link'] . '">' . $menu['title'] . '</a>';
            
            if (!empty($menu['children'])) {
                renderMenu($menu['children']);
            }
            
            echo '</li>';
        }
        echo '</ul>';
    }

    renderMenu($menus);
?>