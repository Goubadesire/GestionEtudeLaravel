<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->foreignId('matiere_id')->after('id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->after('matiere_id')->constrained()->cascadeOnDelete();
            $table->decimal('valeur', 5, 2)->after('user_id'); // note sur 20 par exemple
            $table->integer('coef')->default(1)->after('valeur'); // coefficient, par défaut 1
            $table->text('commentaire')->nullable()->after('coef');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['matiere_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['matiere_id', 'user_id', 'valeur', 'coef', 'commentaire', 'created_at', 'updated_at']);
        });
    }
};
