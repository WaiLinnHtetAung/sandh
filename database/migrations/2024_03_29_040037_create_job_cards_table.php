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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();
            $table->string('job_card_no');
            $table->integer('customer_id');
            $table->string('job_title');
            $table->integer('job_type_id');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->date('delivery_date');
            $table->longText('remark');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_complete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_cards');
    }
};
