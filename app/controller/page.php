<?php
Namespace Controller;

class Page {
    public function get_page($f3){
        if(!file_exists($f3->UI . "page/" . $f3->PARAMS['halaman'] . ".html"))
            return $f3->error(404);
        \View\Template::render("page/" . $f3->PARAMS['halaman'] . ".html", $f3->PARAMS['halaman']);
    }
}