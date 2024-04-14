<?php

use App\Enums\Reply;
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

        Schema::create('campaign_contact', function (Blueprint $table) {
            $replies = collect(Reply::cases())->pluck('value')->toArray();

            $table->foreignId('campaign_id')->constrained();
            $table->foreignId('contact_id')->constrained();
            $table->primary(['campaign_id', 'contact_id']);
            $table->enum('reply',$replies)->default($replies[0]);
            $table->text('notes')->nullable();
            $table->timestamp('visited_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_contact');
    }
};
