<?php

namespace App\DTO;

abstract class ParseDTO
{
    public static function list($objlist, $clsdto)
    {
        $result = [];
        foreach ($objlist as $key => $value) {
            array_push($result, new $clsdto($value));
        }
        return $result;
    }

    public static function obj($obj, $clsdto)
    {
        return new $clsdto($obj);
    }
}
