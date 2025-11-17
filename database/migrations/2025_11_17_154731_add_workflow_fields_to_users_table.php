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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('business_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('phone')->nullable();
            $table->integer('age')->nullable();
            $table->string('location')->nullable();
            $table->boolean('enabled_mfa')->default(false);
            $table->timestamp('mfa_sent_at')->nullable();
            $table->string('mfa_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropColumn(['business_id', 'phone', 'age', 'location', 'enabled_mfa', 'mfa_sent_at', 'mfa_code']);
        });
    }
};
