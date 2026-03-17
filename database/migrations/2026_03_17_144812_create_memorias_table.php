<?php

use App\Models\paciente;
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
        Schema::create('memorias', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(paciente::class)->constrained()->onDelete('cascade');
            $table->string('foto');
            $table->string('descripcion',40);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorias');
    }
};
