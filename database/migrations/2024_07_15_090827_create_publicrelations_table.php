<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publicrelations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userid');
            $table->bigInteger('delet_flag')->default(0);
            $table->bigInteger('departmentid');
            $table->date('date');
            $table->integer('publicreltypeid')->unsigned();
            $table->boolean('status_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicrelations');
    }
};
