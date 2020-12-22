<?php namespace Harryfurnish\Philterplugin\Components;

use Cms\Classes\ComponentBase;
use Auth;
use Flash;
use Redirect;
use Db;
use Input;
use Harryfurnish\Philterplugin\Models\Image as ImageModel;

class DeleteImages extends ComponentBase
{
	public $imageId;
    public function componentDetails()
    {
        return [
            'name'        => 'DeleteImages Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }
	
	public function onRender(){
		$user = Auth::getUser();
		//echo ($this->param('imageid'));
		//$imageId = $this->param('imageid');
		$model = ImageModel::find($this->param('imageid'));
		if (is_object($user && $model->user_id == $user)){
			$model->image->delete();
			$model->delete();
			Flash::success('Your image has been deleted');
		}
		else{
			Flash::success('you are not logged in or authorised to delete this image');
		}
		
		//return Redirect::back();
		//echo imageId;
	}
	
	public function DeleteImages($imageid){
		$model = ImageModel::find(imageId);
		$model->file->delete();
		$model->delete();
		return Redirect::back();
	}
}
