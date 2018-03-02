<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('gender');
            $table->date('dob');
            $table->string('username', 50)->unique();
            $table->string('email',70)->unique();
            $table->string('official_phone', 20)->nullable();
            $table->string('password');
            //if user is inactive it will be 1
            $table->boolean('is_locked')->default(false);
            // if user is logged in it will be 1
            $table->boolean('is_login')->default(false);
            $table->string('user_ip')->nullable();

            $table->string('department_id')->nullable();
            $table->string('school_id')->nullable();
            //who created the user
            $table->string('created_by', 50)->nullable()->index();
            $table->integer('password_attempt_count')->unsigned()->nullable();
            $table->dateTime('password_attempt_date')->nullable();
            $table->boolean('must_change_password')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
