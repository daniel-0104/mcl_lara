<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Check if the columns already exist before adding them
            if (!Schema::hasColumn('password_reset_tokens', 'email')) {
                $table->string('email')->primary();
            }

            if (!Schema::hasColumn('password_reset_tokens', 'token')) {
                $table->string('token');
            }

            if (!Schema::hasColumn('password_reset_tokens', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
        });
    }

    public function down() {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('password_reset_tokens', 'email')) {
                $table->dropPrimary(['email']);
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('password_reset_tokens', 'token')) {
                $table->dropColumn('token');
            }

            if (Schema::hasColumn('password_reset_tokens', 'created_at')) {
                $table->dropColumn('created_at');
            }
        });
    }
};
