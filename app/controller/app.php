<?php
Namespace Controller;

class App {
    public function get_hello($f3){
        \View\Template::render("index.html", "Wow");
    }

    public function get_migrate($f3){
        \Model\User::setup();
        \Model\RetriveralLog::setup();
    }
}