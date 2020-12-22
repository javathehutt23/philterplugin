<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHarryfurnishPhilterpluginImageTag extends Migration
{
    public function up()
    {
        Schema::create('harryfurnish_philterplugin_image_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('image_id');
            $table->integer('tag_id');
            $table->primary(['image_id','tag_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('harryfurnish_philterplugin_image_tag');
    }
}
