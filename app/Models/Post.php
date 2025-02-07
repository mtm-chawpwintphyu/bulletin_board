<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'create_user_id', 'updated_user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'create_user_id');
    } 
    public function updater()
{
    return $this->belongsTo(User::class, 'updated_user_id');
}  
    
}
