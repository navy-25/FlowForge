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
        Schema::create('workflow_run_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_run_id')
                ->constrained('workflow_runs')
                ->onDelete('cascade');
            $table->string('node_id');  # key_name for identity
            $table->string('status')->default('pending');
            // [
            //     'pending',  # not yet in the queue
            //     'queued',   # waiting in line
            //     'running',
            //     'success',
            //     'failed',
            //     'retrying',
            // ]
            $table->json('output')->nullable();
            $table->json('context')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_run_steps');
    }
};
