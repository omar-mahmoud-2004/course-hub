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
    Schema::table('courses', function (Blueprint $table) {
        $table->foreignId('teacher_id')->nullable()->after('category_id')->constrained('users')->nullOnDelete();
        $table->string('title')->after('teacher_id');
        $table->text('description')->nullable()->after('title');
        $table->decimal('price', 8, 2)->default(0.00)->after('description');
        $table->string('image')->nullable()->after('price');
    });
}

public function down(): void
{
    Schema::table('courses', function (Blueprint $table) {
        $table->dropConstrainedForeignId('teacher_id');
        $table->dropColumn(['title', 'description', 'price', 'image']);
    });
}
};
