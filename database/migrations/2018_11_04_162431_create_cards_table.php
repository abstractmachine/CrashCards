<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('subtitle')->nullable();
            $table->unsignedInteger('author_id')->nullable();
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
        Schema::dropIfExists('cards');
    }

    /**
     * 2018_11_04_162431_create_cards_table has one Author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = 2018_11_04_162431_create_cards_table_id, localKey = id)
        return $this->hasOne(User::class, 'author');
    }
}
