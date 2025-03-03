<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'status', 'create_user_id', 'updated_user_id', 'created_at', 'updated_at'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;
    /**
     * Get the user that owns the current model.
     *
     * This defines the relationship where the current model belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the user who created the current model.
     *
     * This defines the relationship where the current model belongs to a User, 
     * with a foreign key of `create_user_id`, indicating the user who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'create_user_id');
    }
    /**
     * Get the user who last updated the current model.
     *
     * This defines the relationship where the current model belongs to a User,
     * with a foreign key of `updated_user_id`, indicating the user who last updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}



