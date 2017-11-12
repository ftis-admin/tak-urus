<?php
namespace Model;
class User extends \DB\Cortex {
    protected
    $fieldConf = [
        'email' =>[
            'type' => \DB\SQL\Schema::DT_TEXT
        ],
        'name'=>[
            'type' => \DB\SQL\Schema::DT_TEXT
        ],
        'givenname'=>[
            'type' => \DB\SQL\Schema::DT_TEXT
        ],
        'familyname'=>[
            'type' => \DB\SQL\Schema::DT_TEXT
        ],
        'created_on'=>[
             'type' => \DB\SQL\Schema::DT_DATETIME
        ],
        'updated_on'=>[
             'type' => \DB\SQL\Schema::DT_DATETIME
        ],
        'deleted_on'=>[
             'type' => \DB\SQL\Schema::DT_DATETIME
        ]
    ],
    $db = 'DB',
    $table = 'user';

    function set_created_on($time){
        return date('Y-m-d H:i:s', $time);
    }

    function set_updated_on($time){
        return date('Y-m-d H:i:s', $time);
    }

    function set_deleted_on($time){
        return date('Y-m-d H:i:s', $time);
    }

    function save() {
        if(!$this->created_on)
            $this->created_on = time();
        $this->updated_on = time();
        parent::save();
    }

    public function __construct() {
        parent::__construct();

        parent::virtual('username', function($umu){
            $matching = [];
            preg_match("/7([1-3])([0-9]{2})([0-9]{3})\@student\.unpar\.ac\.id/", $umu->email, $matching);
            $jurusan = ["1"=>"m", "2"=>"f", "3"=>"i"];
            return sprintf("%s%s%s", $jurusan[$matching[1]], $matching[2], $matching[3]);
        });
    }

    public static function from_id_token($id_token){
        $user = new User();
        $user->reset();
        $user->load(['email=?', $id_token['email']]);
        if($user->loaded() < 1) {
            $user->copyfrom([
                'email' => $id_token['email'],
                'name'  => mb_convert_case(strtolower($id_token['name']), MB_CASE_TITLE),
                'givenname'  => mb_convert_case(strtolower($id_token['given_name']), MB_CASE_TITLE),
                'familyname'  => mb_convert_case(strtolower($id_token['family_name']), MB_CASE_TITLE)
            ]);
        }
        if($user->name != mb_convert_case(strtolower($id_token['name']), MB_CASE_TITLE))
            $user->name=mb_convert_case(strtolower($id_token['name']), MB_CASE_TITLE);
        if($user->givenname != mb_convert_case(strtolower($id_token['given_name']), MB_CASE_TITLE))
            $user->givenname=mb_convert_case(strtolower($id_token['given_name']), MB_CASE_TITLE);
        if($user->familyname != mb_convert_case(strtolower($id_token['family_name']), MB_CASE_TITLE))
            $user->familyname=mb_convert_case(strtolower($id_token['family_name']), MB_CASE_TITLE);
        if($user->changed())
            $user->save();
        return $user;
    }
}