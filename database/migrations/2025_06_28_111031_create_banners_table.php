<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->string('type')->nullable();
            $table->boolean('status')->default(true);
            $table->string('videos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
