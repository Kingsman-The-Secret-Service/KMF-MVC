<?php

namespace KMF;


Class Registry{

    private $data = array();

    public function __set($varName, $varValue) {
        $this->data[$varName] = $varValue;
    }

    public function __get($varName) {
        return $this->data[$varName];
    }
}