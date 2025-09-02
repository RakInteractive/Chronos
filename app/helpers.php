<?php

if (!function_exists('formatJsonIfPossible')) {
    function formatJsonIfPossible($content) {
        $decoded = json_decode($content, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        return $content;
    }
}
