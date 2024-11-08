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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer('from');
            $table->integer('kafedra_id');
            $table->text('description');
            $table->integer('room')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('building')->nullable();
            $table->enum('status',['new', 'progress', 'done', 'failed'])->default('new');
            $table->boolean('confirm')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
