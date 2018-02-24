<?php
Namespace Controller;

class Auth {
    public function get_google_callback($f3) {
        if(!$f3->GET['code'])
            $f3->reroute('@root');
        $client = $f3->google_api['client'];
        $token = $client->fetchAccessTokenWithAuthCode($f3->GET['code']);
        $client->setAccessToken($token);

        $id_token = $client->verifyIdToken();
        
        if(preg_match("/7[1-3][0-9]{5}(\@student\.unpar\.ac\.id)/",$id_token['email'])!= 1) {
            \Flash::instance()->addMessage('Kita hanya menerima akun @student.unpar.ac.id dengan Fakultas FTIS & angkatan 2016 kebawah.', 'danger');
            return $f3->reroute('@root');
        }
        
        $f3->SESSION['gtoken'] = $token;
        // email a pemberitahuan
        
        $f3->reroute('@root');
    }

    public function post_google_callback($f3) {
        // clear up those login histories.
        $f3->clear('SESSION');
        $f3->reroute($f3->google_api['client']->createAuthUrl());
    }
}