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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->text('password');
            $table->string('profile')->default('default_profile');
            $table->tinyInteger('type')->default(1)->comment('0 for Admin, 1 for User');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('created_user_name')->nullable();
            $table->bigInteger('create_user_id')->unsigned();
            $table->bigInteger('updated_user_id')->unsigned();
            $table->foreign('create_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('deleted_user_id')->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });

        // Create password reset tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

    }

    public function down(): void
    {

        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile')->nullable(false)->change();
            $table->dropColumn('created_user_name');
            $table->dropForeign(['create_user_id']);
            $table->dropForeign(['updated_user_id']);
            $table->dropColumn('create_user_id');
            $table->dropColumn('updated_user_id');
        });
    }
};
