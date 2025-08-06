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

        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            //main info
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('cascade');

            //logo and description
            $table->text('description')->nullable();
            $table->string('logo')->nullable();

            $table->string('website')->nullable();

            

           
            
            //   bussieness info
            $table->string('industry')->nullable(); 
            $table->string('tax_id')->nullable();  
            $table->string('registration_number')->nullable(); 

            

    
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);

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

        Schema::dropIfExists('companies');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

};
