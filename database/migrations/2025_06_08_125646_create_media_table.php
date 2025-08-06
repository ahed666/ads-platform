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
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type')->default('image'); // image أو video
            $table->string('path'); 
            $table->string('alt')->nullable(); 
            $table->timestamps();
        });
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('media');
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
