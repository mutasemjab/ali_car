<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('phone')->unique()->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('user_type');  // 1 tameen   // 2 vendor
            $table->string('photo')->nullable();
            $table->text('fcm_token')->nullable();
            $table->tinyInteger('activate')->default(1); // 1 yes //2 no
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
