<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    // Schema::create('members', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('id_user')->unsigned();
        //     $table->string('nama', 100);
        //     $table->string('email', 100)->unique();
        //     $table->string('status', 20)->default('pending');
        //     $table->string('upload_bukti', 100)->nullable();
        //     $table->date('expired_at')->nullable();
        //     $table->timestamps();
        // });
    protected $fillable = [
        'id_user',
        'nama',
        'email',
        'status',
        'upload_bukti',
        'expired_at',
    ];  

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
