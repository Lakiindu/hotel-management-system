<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('room_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('guests');
            $table->text('special_requests')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'cancelled',
                'checked_in',
                'checked_out',
                'completed'
            ])->default('pending');

            $table->decimal('total_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};