<?php
namespace Controller;
use \Firebase\JWT\JWT;
class File {
    public function get_file($f3) {
        $jwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9." . $f3->PARAMS['token'] . "." . $f3->PARAMS['sign'];
        $data = null;
        try {
            $data = JWT::decode($jwt, $f3->get('SECURITY.jwt_token'), array('HS256'));
        } catch (\Exception $e){
            return $f3->error(400, "Token tidak valid. Anda kurang beruntung.");
        }

        //var_dump($data);
        
        // lempar filenya.
        $filename = $data->dzf;
        if(!is_file($f3->ZZIP . $filename)){
            return $f3->error(404, "File yang anda cari tidak ada.");
        }

        \Web::instance()->send($f3->ZZIP . $filename);
    }
    public function get_page($f3) {
        $filename = $f3->USER['object']->username . ".zip";
        if(!is_file($f3->ZZIP . $filename)){
            return \View\Template::render("download-invalid.html");
        }
        $token = array(
            "iss" => $f3->get("SCHEME") . "://" . $f3->get("SERVER.HTTP_HOST"),
            "aud" => $f3->get("SCHEME") . "://" . $f3->get("SERVER.HTTP_HOST"),
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + 3600*2,
            "dzf" => $f3->USER['object']->username . ".zip"
        );
        $jwt = JWT::encode($token, $f3->get('SECURITY.jwt_token'));
        $tokens = explode(".", $jwt);
        $f3->set("file", ["token"=>$tokens[1], "sign"=>$tokens[2], "jwt"=>$jwt]);
        return \View\Template::render("download.html");
    }
}