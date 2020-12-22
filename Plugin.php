<?php namespace HarryFurnish\Philterplugin;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function registerComponents()
    {
		return [
            'Harryfurnish\Philterplugin\Components\RecentImages' => 'RecentImages',
			'Harryfurnish\Philterplugin\Components\UserImages' => 'UserImages',
			'Harryfurnish\Philterplugin\Components\AddImages' => 'AddImages',
			'Harryfurnish\Philterplugin\Components\DeleteImages' => 'DeleteImages',
        ];
    }

    public function registerSettings()
    {
    }
}
