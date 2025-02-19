<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('description');
            $table->integer('status')->default(1);
            $table->foreignId('create_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_user_id')->constrained('users')->onDelete('cascade');
            $table->integer('deleted_user_id')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
