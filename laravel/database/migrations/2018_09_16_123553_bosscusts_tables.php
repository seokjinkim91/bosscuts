<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BosscustsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
        Schema::create('users', function (Blueprint $table) {
                   
                    $table->increments('user_id');
                    $table->string('password');
                    $table->string('name');
                    $table->string('contact')->nullable();
                    $table->string('email')->unique();
                    $table->string('role')->nullable();
                    $table->boolean('enable')->nullable(); // 0, 1
                    $table->string('photo_url') ->nullable();
                    $table->timestamps();
                    $table->rememberToken();
        });
        
        Schema::create('datetimes', function (Blueprint $table) {
                    $table->string('datetime_id');
                    $table->dateTime('date_time');
                    $table->integer('year');
                    $table->integer('month');
                    $table->string('month_name');
                    $table->integer('day');
                    $table->string('day_name');
                    $table->string('hour'); //0900, 1130, 1300
                    $table->string('week_str'); //2018W13, 2019W01
                    $table->timestamps();
                    $table->primary('datetime_id');
        });
        
        
        Schema::create('bookings', function (Blueprint $table) {
                    $table->increments('booking_id');
                    $table->string('datetime_id');
                    $table->string('user_id');
                    $table->string('booking_name');
                    $table->string('booking_contact');
                    $table->string('booking_email');
                    $table->string('booking_status'); //waiting, booked, cancelled
                    $table->integer('service_id');
                    $table->string('booking password') ->nullable();
                    $table->mediumText('booking_memo') ->nullable();
                    $table->timestamps();
        });
        
        Schema::create('services', function (Blueprint $table) {
                    $table->increments('service_id');
                    $table->string('service_title');
                    $table->integer('service_mins');
                    $table->string('service_type');
                    $table->integer('service_priority') ->nullable(); 
                    $table->double('service_price',8,2);
                    $table->mediumText('service_desc') ->nullable();
                    $table->timestamps();

        });
        
        
        Schema::create('applicants', function (Blueprint $table) {
                    $table->increments('applicant_id');
                    $table->string('applicant_email');
                    $table->string('applicant_firstname');
                    $table->string('applicant_surname');
                    $table->string('applicant_contact');
                    $table->string('applicant_password') ->nullable();
                    $table->string('applicant_type');
                    $table->string('applicant_file_url') ->nullable();
                    $table->mediumText('applicant_memo') ->nullable();
                    $table->timestamps();
        });
        
        Schema::create('users_datetimes', function (Blueprint $table) {
                    $table->string('datetime_id');
                    $table->integer('user_id');
                    $table->string('status');   //available, booked, waiting
                    $table->timestamps();
        });
        
        Schema::create('users_services', function (Blueprint $table) {
                    $table->integer('service_id');
                    $table->integer('user_id');
                    $table->string('status'); //enable, disable
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
        Schema::dropIfExists('datetimes');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('services');
        Schema::dropIfExists('applicants');
        Schema::dropIfExists('users_datetimes');
        Schema::dropIfExists('users_services');
    }
}
