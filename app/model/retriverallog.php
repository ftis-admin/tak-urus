<?php
namespace Model;
class RetriveralLog extends \DB\Cortex {
    protected
    $fieldConf = [
        'user' =>[
            'belongs-to-one' => '\\Model\\User' 
        ],
        'type'=>[
            'type' => \DB\SQL\Schema::DT_TEXT
        ],
        'detail'=>[
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
    $table = 'retriveral_log';

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
}