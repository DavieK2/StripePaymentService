<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_payment_methods', 'payment_method_id', 'user_id')
                    ->withPivot(['is_default'])
                    ->withTimestamps();
    }

    function hasBeenAddedByUser($userId)
    {
        return $this->users->firstWhere('id', $userId)?->id === $userId;
    }
}
