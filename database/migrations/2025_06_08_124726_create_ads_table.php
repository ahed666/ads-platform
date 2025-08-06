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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ad_type_id')->constrained('ad_types')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('model_id')->nullable()->constrained('brand_models')->onDelete('set null');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('slug')->unique();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('availability', ['available', 'sold', 'rented'])->default('available');
            $table->enum('purpose', ['for_sale', 'for_rent'])->default('for_sale');
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->json('attributes')->nullable();
            $table->json('features')->nullable();
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
        Schema::dropIfExists('ads');
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};