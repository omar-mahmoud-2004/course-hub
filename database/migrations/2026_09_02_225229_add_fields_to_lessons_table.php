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
    Schema::table('lessons', function (Blueprint $table) {
        if (!Schema::hasColumn('lessons', 'course_id')) {
            $table->foreignId('course_id')->after('id')->constrained('courses')->onDelete('cascade');
        }
        if (!Schema::hasColumn('lessons', 'title')) {
            $table->string('title')->after('course_id');
        }
        if (!Schema::hasColumn('lessons', 'description')) {
            $table->text('description')->nullable()->after('title');
        }
        if (!Schema::hasColumn('lessons', 'video_url')) {
            $table->string('video_url')->nullable()->after('description');
        }
        if (!Schema::hasColumn('lessons', 'duration')) {
            $table->string('duration')->nullable()->after('video_url');
        }
    });
}

public function down(): void
{
    Schema::table('lessons', function (Blueprint $table) {
        $table->dropForeign(['course_id']);
        $table->dropColumn(['course_id', 'title', 'description', 'video_url', 'duration']);
    });
}
};
