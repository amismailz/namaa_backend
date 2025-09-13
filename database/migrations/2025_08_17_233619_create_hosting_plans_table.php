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
        Schema::create('hosting_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // اسم الخطة
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // السعر بالجنيه
            $table->string('currency')->nullable()->default('EGP'); // العملة
            $table->string('billing_cycle')->nullable()->default('year'); // مدة الاشتراك
            $table->integer('email_accounts')->nullable(); // عدد حسابات البريد
            $table->string('storage')->nullable(); // مساحة التخزين
            $table->string('bandwidth')->nullable(); // معدل نقل البيانات
            $table->boolean('free_domain')->nullable()->default(false);
            $table->boolean('is_most_popular')
                ->default(false)
                ->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('our_services')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosting_plans');
    }
};
