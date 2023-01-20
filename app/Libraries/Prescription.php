<?php namespace App\Libraries;

class Prescription{

    public function postItem($params){
        return view('components/post_item', $params);
    }
}