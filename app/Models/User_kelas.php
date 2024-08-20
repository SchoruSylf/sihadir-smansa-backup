<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_kelas extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Assuming 'user_id' is the foreign key in 'user_kelas' table
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); // Assuming 'user_id' is the foreign key in 'user_kelas' table
    }
}
