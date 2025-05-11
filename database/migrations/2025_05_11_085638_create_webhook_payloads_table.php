<?php

use App\Enums\WebhookPayloadStatus;
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
        Schema::create('webhook_payloads', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->text('payload');
            $table->integer('status')->default(WebhookPayloadStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_payloads');
    }
};
