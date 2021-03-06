<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{
    /**
     * Set up the options.
     */
    public function __construct()
    {
        $this->table = config('laravel-settings.database.table');
        $this->key = config('laravel-settings.database.key');
        $this->value = config('laravel-settings.database.value');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string($this->key)->index();
            $table->text($this->value);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
