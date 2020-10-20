<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    public $incrementing = false;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('account')->nullable();
            $table->string('owner')->nullable();
            $table->string('name')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('token')->nullable();
            $table->string('expires_in')->nullable();
            $table->integer('skillpoints_total')->nullable();
            $table->integer('skillpoints_min')->default(5500000);
            $table->timestamp('refreshed_at')->useCurrent();
            $table->date('paid_until')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
