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
            Schema::create('albums', function (Blueprint $table) {
                $table->id();

                $table->foreignId('group_id')
              ->constrained()
              ->onDelete('cascade');

                $table->string('name');
                $table->date('release_date')->nullable();
                $table->integer('track_count')->default(0);
                $table->string('title_track')->nullable();
                $table->decimal('price', 8, 2)->nullable();

                $table->timestamps();
        });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
