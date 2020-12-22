<?php namespace Harryfurnish\Philterplugin\Components;

use Cms\Classes\ComponentBase;
use Auth;
use Harryfurnish\Philterplugin\Models\Image as ImageModel;

class RecentImages extends ComponentBase
{
	public $images;
    public function componentDetails()
    {
        return [
            'name'        => 'RecentImages',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
			'recentimage' => [
                'description'       => 'The most recent images added',
                'title'             => 'Recent Images'
				]
		];
    }

	public function onRender()
    {
        $user = Auth::getUser();
        if (is_object($user)) {
					//echo ($user->id);
            $this->images = ImageModel::othersImages($user->id)->latest()->get();
        } else {
            $this->images = ImageModel::latest()->get();
        }
    }

		/*public function onRender(){
			$this->images = ImageModel::latest()->get();
			//print("<pre>".print_r($this->images, 1)."</pre>");
			//die();
		}*/
}
