<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rfid_logs', function (Blueprint $table) {
            $table->id();
            $table->string('device_id', 50)->index();
            $table->string('rfid_uid', 50)->index();
            $table->foreignId('student_id')->nullable()->index();
            $table->timestamp('scanned_at')->index();
            $table->boolean('success')->default(false)->index();
            $table->string('message')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            // Indexes for better query performance
            $table->index(['device_id', 'scanned_at']);
            $table->index(['student_id', 'scanned_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('rfid_logs');
    }
};