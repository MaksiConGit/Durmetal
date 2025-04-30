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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->foreignId('province_id')->constrained()
                                                ->onDelete('restrict')
                                                ->onUpdate('cascade');
            $table->string('phone');
            $table->foreignId('iva_condition_id')->constrained()
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->foreignId('document_type_id')->constrained()
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->boolean('is_active');
            $table->foreignId('client_classification_id')->constrained()
                                                        ->onDelete('restrict')
                                                        ->onUpdate('cascade');
            $table->foreignId('created_by')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')
                                            ->onDelete('restrict')
                                            ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
