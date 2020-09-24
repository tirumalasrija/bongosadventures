<?php

namespace BongosBooks\Lessons;

class TemplateEngine
{
    private static $views_dir = '/../views/';
    private static $views_ext = '.php';

    /**
     * Extract the given variables from $data and include the template.
     * Echoing the output is optional.
     *
     * @param string  $template_name
     * @param array   $context
     * @param boolean $echo
     * @return string|bool
     */
    public static function render($template_name, $context = array(), $echo = true)
    {
        $file_safe_name = strtolower(str_replace(' ', '-', $template_name));
        $template_path = __DIR__ . self::$views_dir . $file_safe_name . self::$views_ext;
        if (!file_exists($template_path)) {
            return false;
        }
        extract($context);
        ob_start();
        include($template_path);
        $output = ob_get_clean();
        if ($echo) {
            echo $output;
        }

        return $output;
    }

    /**
     * Takes a string, replaces the "shortcodes" (e.g. [variable1]) with the real values from $data
     * and echos the string.
     * Echoing the string is optional.
     *
     * @param string  $template_string
     * @param array   $context
     * @param boolean $echo
     * @return string
     */
    public static function render_string($template_string, $context = array(), $echo = true)
    {
        foreach ($context as $k => $v) {
            $template_string = str_replace('[' . $k . ']', $v, $template_string);
        }
        if ($echo) {
            echo $template_string;
        }

        return $template_string;
    }
}
