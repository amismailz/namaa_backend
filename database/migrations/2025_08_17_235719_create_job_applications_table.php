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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // الاسم
            $table->string('email'); // البريد الإلكتروني
            $table->string('phone'); // رقم الهاتف
            $table->string('image'); // رسالة
            $table->enum('job_title', [ // Job Title
                'Web Developer',
                'Web Designer',
                'Graphic Designer',
                'Call Center',
            ]);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
