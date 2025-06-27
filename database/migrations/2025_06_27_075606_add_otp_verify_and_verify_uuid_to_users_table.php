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
        Schema::table('users', function ($table) {
            $table->boolean('otp_verify')->default(0)->after('remember_token'); // or after any column you prefer
            $table->string('verify_uuid')->nullable()->after('otp_verify');
        });
    }

    public function down(): void
    {
        Schema::table('users', function ($table) {
            $table->dropColumn(['otp_verify', 'verify_uuid']);
        });
    }

};
