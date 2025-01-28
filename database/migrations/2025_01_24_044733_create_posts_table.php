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
            $table->foreignId('deleted_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();

        });
        DB::table('posts')->insert([
            'title' => 'Post Title 01',
            'description' => 'Description 01.',
            'status' => 1,
            'create_user_id' => 1, 
            'updated_user_id' => 1,
            'deleted_user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
