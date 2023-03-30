<?php
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->datetime('startDateTime');
            $table->foreignId('teacherId')->constrained('users');
            $table->foreignId('studentId')->constrained('users');
            $table->enum('lessonType', ['guitar', 'bass', 'piano', 'vocal']);
            $table->enum('status', ['available', 'booked', 'cancelled']);
            $table->boolean('paymentConfirmation');
            $table->timestamp('bookingTS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};