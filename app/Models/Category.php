<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "dhl_cats";

    protected $fillable = ['categoryId', 'groupId', 'name', 'sla', 'isDeleted'];
}
