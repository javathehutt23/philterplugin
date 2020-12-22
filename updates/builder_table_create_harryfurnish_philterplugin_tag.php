<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHarryfurnishPhilterpluginTag extends Migration
{
    public function up()
    {
        Schema::create('harryfurnish_philterplugin_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('tag');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('harryfurnish_philterplugin_tag');
    }
}
