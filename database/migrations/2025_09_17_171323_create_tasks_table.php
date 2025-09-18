<?php

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', [
                TaskStatus::NEW->value,
                TaskStatus::IN_PROGRESS->value,
                TaskStatus::COMPLETED->value,
                TaskStatus::CANCELLED->value,
            ])->default(TaskStatus::NEW->value);
            $table->enum('priority', [
                TaskPriority::HIGH->value,
                TaskPriority::NORMAL->value,
                TaskPriority::LOW->value,
            ])->default(TaskPriority::NORMAL->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
