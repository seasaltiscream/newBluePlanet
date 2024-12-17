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
        Schema::create('volunteer_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // This is the form title
            $table->text('description');
            $table->string('creator')->nullable();
            $table->string('link');
            $table->string('status')->nullable();
            $table->string('user_id')->nullable();
            $table->string('image')->nullable();  // New column for image
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_forms');
    }
};
