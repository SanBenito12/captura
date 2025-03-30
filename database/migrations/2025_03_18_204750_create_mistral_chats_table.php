<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mistral_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('prompt');
            $table->text('response');
            $table->string('model')->default('mistral-small-latest');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mistral_chats');
    }
};
