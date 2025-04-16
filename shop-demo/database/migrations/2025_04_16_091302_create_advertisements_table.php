<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('event_type')->nullable(); // Có thể lưu loại sự kiện (nếu có)
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
    
};