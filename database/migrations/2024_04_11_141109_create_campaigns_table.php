<?php

use App\Enums\Status;
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
        Schema::create('campaigns', function (Blueprint $table) {
            $statuses = Status::values();
            $table->id();
            $table->string('uuid')->unique();
            $table->enum('status', $statuses)->default($statuses[0]);
            $table->string('title');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->datetime('publish_date')->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('parking')->nullable();
            $table->string('parking_link')->nullable();
            $table->string('terms_link')->nullable();
            $table->string('data_policy_link')->nullable();
            $table->string('cookies_policy_link')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
