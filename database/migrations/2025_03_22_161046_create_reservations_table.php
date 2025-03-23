<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spectateur_id')->constrained('users');  // Utilise l'id de l'utilisateur pour spectateur
            $table->foreignId('siege_id')->constrained('sieges'); // Utilise l'id du siège
            $table->foreignId('seance_id')->constrained('seances'); // Utilise l'id de la séance
            $table->enum('status', ['pending', 'reserved', 'cancelled'])->default('pending');  // Statut de la réservation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
