<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    const REPORT_REMOVE_NAME_ID = 1;
    const REPORT_MAINTENANCE_NAME_ID = 2;
    const REPORT_DELIVERY_NAME_ID = 3;

    public function scopeSearch($query, $data)
    {
        if (trim($data) != "") {
            return $query->where('d.serial_number', 'LIKE', "%$data%")
                ->whereIn('d.statu_id', [1, 2, 3, 5, 6, 7, 8]);
        }
    }
}
