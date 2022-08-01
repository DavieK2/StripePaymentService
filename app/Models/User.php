<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\StripeCustomer;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class, 'users_payment_methods', 'user_id', 'payment_method_id')
                    ->withPivot(['is_default'])
                    ->withTimestamps();
    }

    public function getDefaultPaymentMethodAttribute()
    {
        return $this->paymentMethods()->get()
                                    ->filter(fn($paymentMethod) => $paymentMethod->pivot->is_default == true)
                                    ?->first()?->only('id', 'payment_method');
    }

    public function stripeAccount(){
        return $this->hasOne(StripeCustomer::class);
    }

    public function getStripeAccountIdAttribute(){
        return $this->stripeAccount->customer_id;
    }

    public function updateStripePaymentMethod(string $paymentMethodId)
    {
        $this->stripeAccount->update(['payment_method_id' => $paymentMethodId ]);
    }
}
