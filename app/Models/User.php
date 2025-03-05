<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
   use HasApiTokens, HasFactory, Notifiable;

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $guarded = [];

   /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
   protected $hidden = [
      'password',
      'remember_token',
   ];



   public function sectionUser()
   {
      return $this->belongsTo(SectionUser::class);
   }

   public function cardPackage()
   {
      return $this->belongsTo(CardPackage::class);
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function addresses()
   {
      return $this->hasMany(UserAddress::class);
   }
   public function orders()
   {
      return $this->hasMany(Order::class);
   }

   public function transfers()
   {
      return $this->hasMany(Transfer::class);
   }


   public function wallets()
   {
      return $this->hasMany(Wallet::class);
   }

   public function favourites()
   {
      return $this->belongsToMany(Product::class, 'favourites', 'user_id', 'product_id');
   }
}
