<?php

namespace App\Core;

/**
 * I18n - Internationalization system for Operon Cortex
 * Supports: pt-BR, en-US, es-ES
 */
class I18n {
    private static $translations = [];
    private static $locale = 'pt-BR';
    private static $loaded = false;

    /**
     * Set the current locale
     */
    public static function setLocale($locale) {
        $validLocales = ['pt-BR', 'en-US', 'es-ES'];
        if (in_array($locale, $validLocales)) {
            self::$locale = $locale;
            self::loadTranslations();
        }
    }

    /**
     * Get current locale
     */
    public static function getLocale() {
        return self::$locale;
    }

    /**
     * Translate a key
     * @param string $key Translation key (e.g., 'dashboard.title')
     * @param array $params Replacement parameters (e.g., [':name' => 'John'])
     * @return string Translated text or key if not found
     */
    public static function t($key, $params = []) {
        if (!self::$loaded) {
            self::loadTranslations();
        }

        $text = self::$translations[$key] ?? $key;
        
        foreach ($params as $k => $v) {
            $text = str_replace($k, $v, $text);
        }
        
        return $text;
    }

    /**
     * Load translations for current locale
     */
    private static function loadTranslations() {
        $file = __DIR__ . "/../../lang/" . self::$locale . ".php";
        
        if (file_exists($file)) {
            self::$translations = include $file;
            self::$loaded = true;
        } else {
            // Fallback to Portuguese
            $fallback = __DIR__ . "/../../lang/pt-BR.php";
            if (file_exists($fallback)) {
                self::$translations = include $fallback;
                self::$loaded = true;
            }
        }
    }

    /**
     * Get all available locales
     */
    public static function getAvailableLocales() {
        return [
            'pt-BR' => ['name' => 'Português (Brasil)', 'flag' => '🇧🇷'],
            'en-US' => ['name' => 'English (US)', 'flag' => '🇺🇸'],
            'es-ES' => ['name' => 'Español', 'flag' => '🇪🇸']
        ];
    }
}
