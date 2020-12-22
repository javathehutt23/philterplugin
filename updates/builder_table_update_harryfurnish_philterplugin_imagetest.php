<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHarryfurnishPhilterpluginImagetest extends Migration
{
    public function up()
    {
        Schema::table('harryfurnish_philterplugin_imagetest', function($table)
        {
            $table->dropColumn('description');
        });
    }
    
    public function down()
    {
        Schema::table('harryfurnish_philterplugin_imagetest', function($table)
        {
            $table->string('description', 191)->nullable()->default('NULL');
        });
    }
}
