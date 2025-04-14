<?php
    function getCurrentTimeWithWords() {
        $hours = date("G");
        $minutes = date("i");

        $minutes = intval($minutes);

        $hourWord = getWordForm($hours, ["час", "часа", "часов"]);
        $minuteWord = getWordForm($minutes, ["минута", "минуты", "минут"]);

        return "$hours $hourWord $minutes $minuteWord";
    }

    function getWordForm($number, $forms) {
        $n = abs($number) % 100;
        $n1 = $n % 10;

        if ($n > 10 && $n < 20) return $forms[2];
        if ($n1 > 1 && $n1 < 5) return $forms[1];
        if ($n1 == 1) return $forms[0];
        return $forms[2];
    }

    // Пример использования:
    echo getCurrentTimeWithWords();
?>