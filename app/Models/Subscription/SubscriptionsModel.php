<?php

namespace App\Models\Subscription;

use App\Models\Auth\UsersModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SubscriptionsModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'status'
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

    public function plan()
    {
        return $this->hasOne(PlansModel::class, "id", "plan_id");
    }

    public function user()
    {
        return $this->hasOne(UsersModel::class, "id", "user_id");
    }
    
}
