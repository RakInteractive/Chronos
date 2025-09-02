<?php

if (!function_exists('formatJsonIfPossible')) {
    function formatJsonIfPossible($content): false|string {
        $content = preg_replace('/\x1b\[[0-9;]*[A-Za-z]/', '', $content);
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $decoded = json_decode($content, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $content;
    }
}
