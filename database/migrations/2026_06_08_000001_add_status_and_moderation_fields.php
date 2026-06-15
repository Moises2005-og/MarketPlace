<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('approved')->after('role_id');
            $table->boolean('must_change_password')->default(false)->after('password');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('approval_status')->default('approved')->after('is_featured');
            $table->unsignedInteger('view_count')->default(0)->after('approval_status');
            $table->index('approval_status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['approval_status']);
            $table->dropColumn(['approval_status', 'view_count']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'must_change_password']);
        });
    }
};
