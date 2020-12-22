<?php namespace Harryfurnish\Philterplugin\Components;

use Cms\Classes\ComponentBase;
use Auth;
use Flash;
use Redirect;
use Db;
use Input;
use Harryfurnish\Philterplugin\Models\Image as ImageModel;
use Harryfurnish\Philterplugin\Models\Tag as TagModel;

class AddImages extends ComponentBase
{
    public $tag;
    public function componentDetails()
    {
        return [
            'name'        => 'AddImages Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
    public function onRender()
  	{
      $this->tag = Db::table('harryfurnish_philterplugin_tag')->select('tag')->get();
  	}

	public function addImage(){
		$image = new ImageModel();
		$image->name = Input::get('name');
		$image->description = Input::get('description');
		$image->user = Auth::getUser();
		$image->file = Input::file('file');
		$image->filter = Input::get('filter');
		$image->save();
		$tags = Input::get('tag');
		$tag_array = explode(',', $tags);
		$tag_models = [];
		foreach ($tag_array as $tag){
			$tag = ucfirst(strtolower(trim($tag)));
			$tag_models[] = TagModel::getTag($tag);
		}
		$image->tags()->attach($tag_models);
		$image->save();
		Flash::success('Your image has been uploaded ');
		echo ($image->file->getPath());
		return Redirect::back();

	}

}
