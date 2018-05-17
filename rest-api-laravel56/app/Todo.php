<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Todo extends Model
{
    use Uuids;

    protected $primaryKey = 'uuid'; // or null

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'content', 'sort_order', 'done'
    ];
}