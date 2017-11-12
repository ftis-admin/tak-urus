<?php
namespace View;

class Email {
    public static function render($page_location) {
        return \Preview::instance()->render("email/" . $page_location);
    }
}