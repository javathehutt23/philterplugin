<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteHarryfurnishPhilterpluginImage extends Migration
{
    public function up()
    {
        Schema::dropIfExists('harryfurnish_philterplugin_image');
    }
    
    public function down()
    {
        Schema::create('harryfurnish_philterplugin_image', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 191);
            $table->string('description', 191)->nullable()->default('NULL');
            $table->integer('user_id')->nullable()->default(NULL);
            $table->string('filter', 191);
        });
    }
}
