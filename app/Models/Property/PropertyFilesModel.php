<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PropertyFilesModel extends Model
{
    
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'property_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [        
        'id',
        'type',
        'file_id',
        'property_id',
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

    public function file()
    {
        return $this->hasOne(FilesModel::class , 'id' , 'file_id');
    }
    

}
