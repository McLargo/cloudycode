<?php

/**
 * Pagination Class which create pagination links.
 * @author Javier Gil
 */
class AjaxPagination {

    private $total_items = 0;
    private $items_per_page = 10;
    private $start = 0;
    private $number_of_links = 3;
    private $pagination_class = 'pagination';
    private $current_page_class = 'current';
    private $previous_page_class = 'prev';
    private $next_page_class = 'next';
    private $disabled_page_class = 'disabled';
    private $function_name_change_page = '';
   
    public function __construct(array $config = array()) {
        $this->setConfig($config);
    }

    public function setConfig(array $config = array()) {
        foreach ($config as $key => $value) {
            if (!property_exists($this, $key))
                throw new Exception("The config parameter {$key} is not a valid pagination parameter");
            $this->$key = $value;
        }
    }

    public function get_links() {
        return $this->create_links();
    }

    private function create_links() {
        $number_of_pages = $this->get_number_of_pages();
        $current_page = $this->get_current_page();
        $numbers_pages = $this->get_range_of_pages_to_show();

        $output = '';

        if ($number_of_pages > 1) {
            $number_first_page = $numbers_pages['start'];
            $number_last_page = $numbers_pages['end'];

            $output .= "<div class='{$this->pagination_class}'>";

            if ($current_page == 0) {
                $output .= "<span class='{$this->disabled_page_class}'><<</span>";
                $output .= "<span class='{$this->disabled_page_class} {$this->previous_page_class}'><</span>";
            } else {
                $start_item = (($current_page - 1) * $this->items_per_page);
                $output .= "<a href='javascript: {$this->function_name_change_page}(0);'><<</a>";
                $output .= "<a class='{$this->previous_page_class}' href='javascript: {$this->function_name_change_page}(" . ($start_item) . ");'><</a>";
                if ($number_first_page > 0)
                    $output .= "<span class='less'>...</span>";
            }

            for ($cont = $number_first_page; $cont < $number_last_page; $cont++) {
                $start_item = $cont * $this->items_per_page;
                if ($current_page == $cont)
                    $output .= "<span class='{$this->current_page_class}'>" . ($cont + 1) . "</span>";
                else
                    $output .= "<a href='javascript: {$this->function_name_change_page}(" . ($start_item) . ");'>" . ($cont + 1) . "</a>";
            }

            if ($current_page == ($number_of_pages - 1)) {
                $output .= "<span class='{$this->disabled_page_class} {$this->next_page_class}'>></span>";
                $output .= "<span class='{$this->disabled_page_class}'>>></span>";
            } else {
                $start_item = (($current_page + 1) * $this->items_per_page);
                if ($number_last_page < $number_of_pages)
                    $output .= "<span class='more'>...</span>";
                $output .= "<a class='{$this->next_page_class}' href='javascript: {$this->function_name_change_page}(" . ($start_item) . ");'>></a>";

                $start_item = (($number_of_pages - 1) * $this->items_per_page);
                $output .= "<a href='javascript: {$this->function_name_change_page}(" . ($start_item) . ");'>>></a>";
            }

            $output .= '</div>';
        }

        return $output;
    }

    private function get_number_of_pages() {
        if ($this->items_per_page == 0)
            return 0;
        return ceil($this->total_items / $this->items_per_page);
    }

    private function get_current_page() {
        return ($this->start / $this->items_per_page);
    }

    private function get_range_of_pages_to_show() {

        if ($this->get_number_of_pages() > $this->number_of_links) {
            $current_page = $this->get_current_page();

            $digit_start = ($current_page - floor($this->number_of_links / 2));
            $digit_end = ($current_page + ceil($this->number_of_links / 2));

            $max_cont = floor($this->get_number_of_pages());

            if ($digit_start < 0) {
                $digit_end += - $digit_start;
                $digit_start = 0;
            }

            if ($digit_end > $max_cont) {
                $digit_start -= ( $digit_end - $max_cont);
                $digit_end = $max_cont;
            }
        } else {
            $digit_start = 0;
            $digit_end = $this->get_number_of_pages();
        }

        return array(
            'start' => $digit_start,
            'end' => $digit_end
        );
    }

}


/*
 $pagination = new AjaxPagination(array(
                'total_items' => $total_rows,
                'items_per_page' => $amount,
                'start' => $start,
                'number_of_links' => 7,
                'function_name_change_page' => 'change_page'
            ));


<br/><div class='pagination_container'><?php print $pagination->get_links(); ?></div><br/>*/
?>