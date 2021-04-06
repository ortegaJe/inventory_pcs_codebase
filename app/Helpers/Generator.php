<?php

namespace App\Helpers;

class Generator {

    public static function IdGenerator($model, $trow, $length = 4, $prefix)
    {
        $data = $model::orderBy('id','desc')->first();

        if(!$data)
        {
            $data_length = $length;
            $last_number = '';
        }
        else
        {
            $code = substr($data->trow,strlen($prefix)+1);
            $data_last_number = ($code/1)*1;
            $increment_last_number = $data_last_number+1;
            $last_number_length = strlen($increment_last_number);
            $data_length = $length - $last_number_length;
            $last_number_length = $increment_last_number;
        }
        $var = "";
        for($i=0; $i<$data_length; $i++)
        {
            $var.="0";
        }
        return $prefix.'-'.$var.$last_number;
    }
}