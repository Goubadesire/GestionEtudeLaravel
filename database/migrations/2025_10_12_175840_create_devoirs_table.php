<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devoirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // appartient à un utilisateur
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_limite')->nullable();
            $table->enum('statut', ['a_faire', 'termine'])->default('a_faire');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devoirs');
    }
};
