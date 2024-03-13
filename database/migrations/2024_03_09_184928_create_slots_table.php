<?php

use App\Models\BarberShop;
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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(BarberShop::class)->constrained();

            $table->date('slot_date');
            $table->time('start_time')->comment('The start time of the Slot H:i:s');
            $table->time('end_time')->comment('The end time of the Slot H:i:s');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
