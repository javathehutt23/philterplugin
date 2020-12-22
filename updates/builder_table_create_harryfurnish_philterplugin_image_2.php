<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHarryfurnishPhilterpluginImage2 extends Migration
{
    public function up()
    {
        Schema::create('harryfurnish_philterplugin_image', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('filter');
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('harryfurnish_philterplugin_image');
    }
}
