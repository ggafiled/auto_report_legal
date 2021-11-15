<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "dhl_status";

    protected $fillable = [
        'statusId',
        'statusName',
        'enabled',
        'enableAfter',
        'statusGroup',
        'isDeleted',
        'isDone',
        'ordering'];
}
