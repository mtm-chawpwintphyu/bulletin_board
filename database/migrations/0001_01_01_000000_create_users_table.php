<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->text('password');
            $table->string('profile');
            $table->tinyInteger('type')->default(1)->comment('0 for Admin, 1 for User');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->foreignId('create_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_user_id')->constrained('users')->onDelete('cascade');
            $table->integer('deleted_user_id')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), 
            'profile' => 'profile-pic.jpg',
            'type' => 0, // Admin 
            'phone' => '09774954125',
            'address' => '123 Main St, Yangon',
            'dob' => '1990-01-01',
            'create_user_id' => 1,  
            'updated_user_id' => 1,
            'deleted_user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create password reset tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the tables in reverse order
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
