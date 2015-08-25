<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMetaSeoTranslations extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('meta_seo_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('meta_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->string('value');

            $table->foreign('meta_id')->references('id')->on('meta_seo')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            $table->unique(['meta_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('meta_seo_translations');
    }
}
