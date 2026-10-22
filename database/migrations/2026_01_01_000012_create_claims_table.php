<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_number')->unique(); // Ej: REC-2026-0001
            $table->enum('type', ['reclamo', 'queja'])->default('reclamo'); // Reclamo: disconformidad con producto/servicio. Queja: malestar en atención.
            
            // Datos del Consumidor
            $table->string('customer_name');
            $table->enum('document_type', ['DNI', 'CE', 'Pasaporte', 'RUC'])->default('DNI');
            $table->string('document_number');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->boolean('is_minor')->default(false);
            $table->string('parent_name')->nullable(); // En caso de ser menor de edad

            // Bien contratado
            $table->enum('contracted_good', ['producto', 'servicio'])->default('producto');
            $table->decimal('amount_claimed', 10, 2)->nullable();
            $table->string('order_number')->nullable();
            $table->text('good_description')->nullable();

            // Detalle de la Reclamación
            $table->text('details');
            $table->text('consumer_request'); // Lo que solicita el consumidor

            // Estado y Respuesta
            $table->enum('status', ['pending', 'in_process', 'resolved', 'rejected'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
