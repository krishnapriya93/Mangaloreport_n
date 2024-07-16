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
        Schema::create('publicrelationsubs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('publicrelationid');
            $table->string('title');
            $table->bigInteger('languageid');
            $table->longText('description',1000);
            $table->string('content',200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicrelationsubs');
    }
};
