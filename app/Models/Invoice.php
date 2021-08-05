<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['receive_date', 'mailroom_bpn_date'];
    protected $table = 'irr5_invoice';
    protected $primaryKey = 'inv_id';
}
