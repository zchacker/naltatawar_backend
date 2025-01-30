<?php

namespace App\Models\Property;

use App\Models\Auth\UsersModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PropertyModel extends Model
{
    
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'property';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [                
        'user_id',
        'parent_id',
        'property_number',
        'title',
        'description',
        'cover_img',
        'images',
        'videos',
        'type',
        'purpose',
        'license_no',
        'space',
        'neighborhood',
        'price',
        'city',
        'location',
        'rooms',
        'bathrooms',
        'kitchen',
        'living_room',
        'elevator',
        'fiber',
        'school',
        'mosque',
        'pool',
        'garden',
        'status',
        'facilities'
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
            'facilities' => 'array'
        ];
    }

    public function add_by()
    {
        return $this->hasOne(UsersModel::class , 'id' , 'user_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyFilesModel::class, 'property_id', 'id');
        //->where('type', 'image');
        //->orderBy('id', 'desc'); // Optional: Get the latest image
    }
    
    public function videos()
    {
        return $this->hasMany(PropertyFilesModel::class, 'property_id', 'id')
        ->where('type', 'video')
        ->orderBy('id', 'desc'); // Optional: Get the latest image
    }

    public function cover()
    {
        return $this->hasOne(FilesModel::class, 'id' , 'cover_img');
    }

}
