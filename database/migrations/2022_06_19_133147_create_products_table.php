<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // adicionando um campo nome do tipo string
            $table->string('name');
                                // aqui nao pode ser nulo
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            // campo do tipo decimal(float) com tamando de 5 caracters antes da virgula e 2 depois
            $table->decimal('price', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
