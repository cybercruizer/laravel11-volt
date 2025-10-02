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
        Schema::table('spa_students', function (Blueprint $table) {
            $table->string('rfid_uid', 50)->nullable()->after('student_nik')->unique()->comment('RFID UID for student identification');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spa_students', function (Blueprint $table) {
            $table->dropColumn('rfid_uid');
        });
    }
};
