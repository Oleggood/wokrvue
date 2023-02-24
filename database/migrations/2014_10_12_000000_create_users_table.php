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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('surname', 40)->nullable(); //фамилия
            $table->string('name'); //имя
            $table->string('patronymic', 40)->nullable(); //отчество
            $table->date('birthday')->nullable(); //день рождения
            $table->integer('nickname')->nullable()->unique(); //прозвище - цыфры
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->longText('note', 500)->nullable(); //примечание
            $table->integer('department_id')->nullable(); //связь - ID структурного подразделения
            $table->integer('position_id')->nullable(); //связь - ID должности
            $table->integer('role_id')->nullable(); //связь - ID таблицы ролей
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
