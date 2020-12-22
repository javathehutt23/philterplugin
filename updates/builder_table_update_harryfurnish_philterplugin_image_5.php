<?php namespace HarryFurnish\Philterplugin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHarryfurnishPhilterpluginImage5 extends Migration
{
    public function up()
    {
        Schema::table('harryfurnish_philterplugin_image', function($table)
        {
            $table->string('description', 191)->nullable(false)->default(null)->change();
            $table->integer('user_id')->nullable(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('harryfurnish_philterplugin_image', function($table)
        {
            $table->string('description', 191)->nullable()->default('NULL')->change();
            $table->integer('user_id')->nullable()->default(NULL)->change();
        });
    }
}
