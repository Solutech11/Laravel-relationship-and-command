<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'tbl_users';
    protected $fillable = ['name', 'address', 'phone', 'password', 'profilePic'];

    public function userPassword(){
        return $this->hasMany(PasswordModel::class,"userId");
    }
}
