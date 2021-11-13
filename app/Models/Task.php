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

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'categoryId', 'category');
    }

    public function assigned_to()
    {
        return $this->hasOne('App\Models\User', 'userId', 'assigned_to');
    }

    public function assigned_by()
    {
        return $this->hasOne('App\Models\User', 'userId', 'assigned_by');
    }

    public function setAddonstatusAttribute($value)
    {
        $properties = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item['key'])) {
                $properties[] = $array_item;
            }
        }

        $this->attributes['properties'] = json_encode($properties);
    }
}
