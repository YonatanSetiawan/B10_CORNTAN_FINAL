<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = ['jumlah_bibit', 'id_jagung', 'id_pupuk', 'id_pestisida', 'tipe_penanaman', 'tgl_mulai'];
}
