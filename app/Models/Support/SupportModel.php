<?php

namespace App\Models\Support;

use App\Models\Auth\UsersModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SupportModel extends Model
{
    
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'support';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'title',
        'message',        
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }

    public function replaies()
    {
        return $this->hasMany(SupportReplayModel::class, "ticket_id", "id")->orderBy('created_at', 'desc');;
    }
    
    public function customer_data()
    {
        return $this->hasOne(UsersModel::class , 'id' , 'customer_id');
    }
    
}
