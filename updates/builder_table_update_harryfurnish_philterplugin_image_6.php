<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHarryfurnishPhilterpluginImage6 extends Migration
{
    public function up()
    {
        Schema::table('harryfurnish_philterplugin_image', function($table)
        {
            $table->string('description', 191)->nullable()->change();
            $table->integer('user_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('harryfurnish_philterplugin_image', function($table)
        {
            $table->string('description', 191)->nullable(false)->change();
            $table->integer('user_id')->nullable(false)->change();
        });
    }
}
