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
}
