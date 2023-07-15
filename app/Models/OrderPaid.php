<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPaid extends Model
{
    protected $table = 'orders_paid';

    protected $fillable = [
        'user_id',
        'brand',
        'price',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
