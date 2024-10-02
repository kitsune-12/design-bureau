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
        //for jira
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_client_id_foreign');
            $table->dropForeign('projects_designer_id_foreign');
            $table->dropColumn('client_id');
            $table->dropColumn('designer_id');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('designer_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_client_id_foreign');
            $table->dropForeign('projects_designer_id_foreign');
            $table->dropColumn('client_id');
            $table->dropColumn('designer_id');
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('designer_id')->constrained('users');
        });
    }
};
