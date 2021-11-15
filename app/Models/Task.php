<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "dhl_tasks";

    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'last_updated' => 'datetime:d/m/Y',
        'addonstatus' => 'array'
    ];

    protected $fillable = [
        'id',
        'title',
        'description',
        'group',
        'category',
        'status',
        'addonstatus',
        'assigned_to',
        'assigned_by',
        'comment',
        'created_at',
        'last_updated',
        'updatedBy',
        'isDeleted'];

    public function ref_category()
    {
        return $this->hasOne('App\Models\Category', 'categoryId', 'category');
    }

    public function ref_assigned_to()
    {
        return $this->hasOne('App\Models\User', 'userId', 'assigned_to');
    }

    public function ref_assigned_by()
    {
        return $this->hasOne('App\Models\User', 'userId', 'assigned_by');
    }

    public function getAddonstatusAttribute($value)
    {
        return json_decode($value);
    }
}
