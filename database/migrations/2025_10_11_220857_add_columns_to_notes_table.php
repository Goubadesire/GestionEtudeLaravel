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
    Schema::table('notes', function (Blueprint $table) {
        $table->foreignId('matiere_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->decimal('valeur', 5, 2)->nullable();
        $table->decimal('coef', 5, 2)->default(1);
        $table->string('commentaire')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            //
        });
    }
};
