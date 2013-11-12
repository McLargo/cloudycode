<?php

class Utils {

    public static function xssClean($value) {
        $not_allowed_words = array(
            'document.cookie' => '[removed]',
            'document.write' => '[removed]',
            '.parentNode' => '[removed]',
            '.innerHTML' => '[removed]',
            'window.location' => '[removed]',
            '-moz-binding' => '[removed]',
            '<!--' => '&lt;!--',
            '-->' => '--&gt;',
            '<![CDATA[' => '&lt;![CDATA['
        );

        /*
         * Decode URL-encoded strings
         * Returns a string in which the sequences with percent (%) signs followed by two hex digits have been replaced with literal characters.
         */
        $value = rawurldecode($value);

        /*
         * Remove <script> and <xss> tags if exists
         */
        if (preg_match("/script/i", $value) || preg_match("/xss/i", $value)) {
            $value = preg_replace("#<(/*)(script|xss)(.*?)\>#si", '[removed]', $value);
        }

        /*
         * It looks for PHP and JavaScript commands
         * that are disallowed.  Rather than removing the
         * code, it simply converts the parenthesis to entities
         * rendering the code un-executable.
         *
         * For example:    eval('some code')
         * Becomes: eval&#40;'some code'&#41;
         */
        $value = preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si', "\\1\\2&#40;\\3&#41;", $value);

        /*
         * Replace some not allowed words
         */
        foreach ($not_allowed_words as $word => $replace_word) {
            $value = str_ireplace($word, $replace_word, $value);
        }

        return $value;
    }

    public static function get_url_post_data($param_name, $default_value = '', $xss_clean = true) {
        $param_value = isset($_POST[$param_name]) ? $_POST[$param_name] : $default_value;

        if (is_string($param_value)) {
            $param_value = stripslashes($param_value);
        }

        if (is_string($param_value) && $xss_clean == true) {
            $param_value = trim($param_value);
            $param_value = self::xssClean($param_value);
        }
        return (strlen($param_value) == 0) ? $default_value : $param_value;
    }

    public static function get_url_request_data($param_name, $default_value = '', $xss_clean = true) {
        $param_value = isset($_REQUEST[$param_name]) ? $_REQUEST[$param_name] : $default_value;

        if (is_string($param_value)) {
            $param_value = stripslashes($param_value);
        }

        if (is_string($param_value) && $xss_clean == true) {
            $param_value = trim($param_value);
            $param_value = self::xssClean($param_value);
        }
        return (strlen($param_value) == 0) ? $default_value : $param_value;
    }

    public static function is_empty($value) {
        if (is_array($value) && count($value) == 0) {
            return true;
        } else if (is_string($value) && strlen(trim($value)) == 0) {
            return true;
        }
        return false;
    }

}

?>
