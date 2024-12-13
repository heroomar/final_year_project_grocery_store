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
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email');
                $table->string('profile_image')->nullable();
                $table->string('type')->default('cutsomer');
                $table->timestamp('email_verified_at')->nullable();
                $table->string('mobile')->nullable();
    
                $table->date('regiester_date')->nullable();
                $table->integer('status')->default(0)->comment('0 => on, 1 => off ');
    
                $table->date('date_of_birth')->nullable();

                $table->integer('created_by')->nullable();
                $table->string('theme_id')->nullable();
                $table->integer('store_id')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
