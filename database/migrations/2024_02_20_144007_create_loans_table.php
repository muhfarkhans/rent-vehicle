<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('return_petugas_id')->nullable();
            $table->float('fuel_cost');
            $table->integer('status');
            $table->string('message');
            $table->date('return_date')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onUpdate('cascade')
                ->onDelete('no action');

            $table->foreign('admin_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('no action');

            $table->foreign('petugas_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('no action');

            $table->foreign('pegawai_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('no action');

            $table->foreign('return_petugas_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
