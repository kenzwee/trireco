<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = array('id');
    
    public static $rules = array(
        'direction' => 'required',
        'image' => 'required',
        'title' => 'required',
        'body' => 'required',
        );
        
    public static $updateRules = array(
        'direction' => 'required',
        'title' => 'required',
        'body' => 'required',
        );
        
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    
    public function histories()
    {
        return $this->hasMany('App\History');
    }
}
