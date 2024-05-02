<?php

use App\Models\Hebergement;
use App\Models\User;
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
        Schema::create('reservation_hebergements', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('en attente');
            $table->integer('places');
            $table->date('date');
            $table->integer('priceTotal');
            $table->foreignIdFor(Hebergement::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_hebergements');
    }
};
