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
        Schema::create('sub_categories', function (Blueprint $table) {
              $table->id();
                $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
                $table->string('name_en');
                $table->string('name_ar');
                $table->string('slug')->unique();
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
        Schema::dropIfExists('sub_categories');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
