<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('payment_method');
            $table->decimal('amount', 8, 2);
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('payments');
    }

};
