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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("room_id");
            $table->date('starts_at');
            $table->date('ends_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('room_id')
                ->references('id')
                ->on('rooms')
            ;

            $table->index(['starts_at', 'ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks');
    }
};
