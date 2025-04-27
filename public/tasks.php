<?php
    echo "<h2>Задание 1</h2>";
    function printNumbers() {
        $i = 0;
        do {
            if ($i === 0) {
                echo "$i – это ноль.<br>";
            } elseif ($i % 2 === 0) {
                echo "$i – чётное число.<br>";
            } else {
                echo "$i – нечётное число.<br>";
            }
            $i++;
        } while ($i <= 10);
    }
    
    printNumbers();


    echo "<h2>Задание 2</h2>";
    $regions = [
        'Московская область' => ['Москва', 'Зеленоград', 'Клин'],
        'Ленинградская область' => ['Санкт-Петербург', 'Всеволожск', 'Павловск', 'Кронштадт'],
        'Рязанская область' => ['Рязань', 'Касимов', 'Скопин']
    ];
    
    foreach ($regions as $region => $cities) {
        echo "<strong>$region</strong>:<br>";
        echo implode(', ', $cities) . ".<br>";
    }


    echo "<h2>Задание 3</h2>";
    function transliterate($string) {
        $alphabet = [
            'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d',
            'е'=>'e', 'ё'=>'yo', 'ж'=>'zh', 'з'=>'z', 'и'=>'i',
            'й'=>'y', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n',
            'о'=>'o', 'п'=>'p', 'р'=>'r', 'с'=>'s', 'т'=>'t',
            'у'=>'u', 'ф'=>'f', 'х'=>'h', 'ц'=>'ts', 'ч'=>'ch',
            'ш'=>'sh', 'щ'=>'sch', 'ъ'=>'', 'ы'=>'y', 'ь'=>'',
            'э'=>'e', 'ю'=>'yu', 'я'=>'ya'
        ];
    
        $string = mb_strtolower($string);
        return strtr($string, $alphabet);
    }
    
    echo "Привет, мир!<br>";
    echo transliterate("Привет, мир!");


    echo "<h2>Задание 4-5</h2>";
    echo "<a href=\"engine1/index.php\">Посмотреть динамическое меню на engine1</a>";


    echo "<h2>Задание 6</h2>";
    foreach ($regions as $region => $cities) {
        $filteredCities = array_filter($cities, function($city) {
            return mb_substr($city, 0, 1) === 'К';
        });
    
        if (!empty($filteredCities)) {
            echo "<strong>$region</strong>:<br>";
            echo implode(', ', $filteredCities) . ".<br>";
        }
    }
?>