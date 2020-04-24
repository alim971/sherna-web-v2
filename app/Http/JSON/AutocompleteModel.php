<?php


namespace App\Http\JSON;


class AutocompleteModel
{



    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }


    public function getJSON() {
        return json_encode($this);
    }
}
