<?php
    chdir(__DIR__);
    // Config Loader
    \F3::instance()->config("config/config.ini");
    
    \F3::set('DB', new \DB\SQL(F3::get('database.dsn'),
        F3::get('database.username'),
        F3::get('database.password'),
        array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ))
    );

    if(file_exists("config/google_client_secret.json")){
        $client = new Google_Client();
        $client->setAuthConfig("config/google_client_secret.json");
        $client->setRedirectUri(\F3::get('SCHEME') . "://" . \F3::get('SERVER.HTTP_HOST') . \F3::get('BASE') . \F3::alias('auth_gugel'));
        $client->addScope('email');
        $client->addScope('profile');
        \F3::set('google_api.client', $client);
    }

    if(\F3::get('SESSION.gtoken')){
        $client = \F3::get('google_api.client');
        $client->setAccessToken(\F3::get('SESSION.gtoken'));
        $id_token = $client->verifyIdToken();
        if($id_token) {
            \F3::set('USER.data', $id_token);
            \F3::set('USER.object', \Model\User::from_id_token($id_token));
            \F3::set('google_api.client', $client);        
        }
    }