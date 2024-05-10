<?php

use App\Enums\HttpMethods;
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
        Schema::create('webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained();
            $table->string('name')->nullable();
            $table->string('url');
            $table->boolean('is_active')->default(true);
            $table->json('headers')->nullable();
            $table->json('payload')->nullable();
            $table->string('bearer_token')->nullable();
            $table->enum('method', HttpMethods::values())->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhooks');
    }
};
