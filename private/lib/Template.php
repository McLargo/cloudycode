<?php

class Template {

    public static function get_template($name, $data = array(), $path = "") {
        $name = ltrim($name, '/');
        if (Utils::is_empty($path)) {
            $path = "/includes/views_templates/";
        }
        $template_path = APP_DIR . '/includes/views_templates/' . $name;
        if (!file_exists($template_path)) {
            throw new Exception('Template file ' . $name . ' does not exists.');
        }

        if (count($data) > 0) {
            extract($data);
        }
        ob_start();
        include $template_path;

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

// name of the file who contains the information
// content is an array wo contents the keys and their values to replace in the template
    public static function fill_template($name, $content, $path='') {

        $name = ltrim($name, '/');
        if (Utils::is_empty($path)) {
            $path = "/includes/views_templates/";
        }
        $template_path = APP_DIR . '/includes/views_templates/' . $name;
        if (!file_exists($template_path)) {
            throw new Exception('Template file ' . $name . ' does not exists.');
        }

        ob_start();
        include $template_path;
        $output = ob_get_contents();
        ob_end_clean();

        foreach ($content as $key => $value) {
            $to_find = "[[" . $key . "]]";
            if (strpos($output, $to_find) !== false) {
                $to_replace = $value;
                $output = str_replace($to_find, $to_replace, $output);
            }
        }
        return $output;
    }

}

/*
  $template_to_fill = 'how/'.$country_code."_first_paragaph_how_page.php";
  $content_to_fill = array (
  'phone_number' => $phone_number,
  'phone_bill' => DBWebContent::get(DBWebContent::PHONE_TO_PAY_VIA_PHONE_BILL),
  );
  print Template::fill_template($template_to_fill, $content_to_fill);
 */
?>
