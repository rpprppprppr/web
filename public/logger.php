<?php
    function logRequest() {
        $logDir = __DIR__ . '/logs/';
        $logFile = $logDir . 'log.txt';

        if (!file_exists($logDir)) mkdir($logDir, 0777, true);
        if (!file_exists($logFile)) file_put_contents($logFile, '');

        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (count($lines) >= 10) {
            $i = 0;
            do {
                $archiveFile = $logDir . "log{$i}.txt";
                $i++;
            } while (file_exists($archiveFile));

            rename($logFile, $archiveFile);
            file_put_contents($logFile, '');
        }

        $time = date('Y-m-d H:i:s');
        file_put_contents($logFile, "Запрос: {$time}\n", FILE_APPEND);
}