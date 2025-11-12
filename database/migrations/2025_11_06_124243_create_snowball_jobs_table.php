<?php

// database/migrations/2025_11_05_000000_create_snowball_jobs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('snowball_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('paper_id');
            $table->string('seed_doi')->nullable();
            $table->string('modes')->default('["backward","forward"]'); // JSON
            $table->enum('status', ['queued','running','completed','failed'])->default('queued');
            $table->unsignedTinyInteger('progress')->default(0); // 0..100
            $table->unsignedInteger('processed')->default(0);
            $table->unsignedInteger('discovered')->default(0);
            $table->unsignedInteger('enqueued')->default(0);
            $table->text('message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['project_id','paper_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snowball_jobs');
    }
};
