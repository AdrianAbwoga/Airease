<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaid extends Model

{
    use HasFactory;
    protected $table = 'orders_paid';

    protected $fillable = [
        'user_id',
        'brand',
        'hotel_name',
        'price',
        'total_price',
        'order_type',
        
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
