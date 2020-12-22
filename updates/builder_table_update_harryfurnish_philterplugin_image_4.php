<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHarryfurnishPhilterpluginImage4 extends Migration
{
    public function up()
    {
        Schema::table('harryfurnish_philterplugin_image', function($table)
        {
            $table->string('description', 191)->default(null)->change();
            $table->integer('user_id')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('harryfurnish_philterplugin_image', function($table)
        {
            $table->string('description', 191)->default('NULL')->change();
            $table->integer('user_id')->default(NULL)->change();
        });
    }
}
