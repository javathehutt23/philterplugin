<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHarryfurnishPhilterpluginImagetest extends Migration
{
    public function up()
    {
        Schema::create('harryfurnish_philterplugin_imagetest', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('filter');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('harryfurnish_philterplugin_imagetest');
    }
}
