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
        Schema::create('photocards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
              ->constrained()
              ->onDelete('cascade');

            $table->foreignId('album_id')
              ->constrained()
              ->onDelete('cascade');

            $table->string('version')->nullable();
            $table->decimal('average_price', 8, 2)->nullable();
            
            $table->unique(['member_id', 'album_id', 'version']);


            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photocards');
    }
};
