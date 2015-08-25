<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMetaSeoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('meta_seo', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('metaable_id');
            $table->string('metaable_type');
            $table->string('key');

            $table->unique(['metaable_id', 'metaable_type', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('meta_seo');
    }
}
