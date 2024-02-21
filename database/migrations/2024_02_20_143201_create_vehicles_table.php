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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_origin_id');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->string('ownership');
            $table->string('name');
            $table->string('police_number');
            $table->string('fuel_type');
            $table->tinyInteger('is_on_loan');
            $table->date('repair_date');
            $table->timestamps();

            $table->foreign('vehicle_origin_id')
                ->references('id')
                ->on('vehicle_origins')
                ->onUpdate('cascade')
                ->onDelete('no action');

            $table->foreign('vehicle_type_id')
                ->references('id')
                ->on('vehicle_types')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
