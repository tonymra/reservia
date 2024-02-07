<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->index();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('adults');
            $table->integer('children')->nullable();
            $table->string('status', 30)->default('pending');
            $table->text('notes')->nullable();
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->string('firstname', 30)->index();
            $table->string('lastname', 30)->index();
            $table->string('phone', 20);
            $table->string('email', 50)->unique();
            $table->string('address', 100);
            $table->string('city', 30);
            $table->string('state', 30);
            $table->string('zipcode', 20)->nullable();
            $table->boolean('shuttle')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('breakfast')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
