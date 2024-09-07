<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

      public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    
}
