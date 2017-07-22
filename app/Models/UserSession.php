<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $visible = [
        'user', 'created_at', 'updated_at', 'session'
    ];
    protected $appends = ['session'];

    /**
     * Renames id to sessionId in JSON
     */
    public function getSessionAttribute()
    {
        return $this->attributes['id'];
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    } // end user

} // end UserSession
