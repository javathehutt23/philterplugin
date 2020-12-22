<?php namespace Harryfurnish\Philterplugin\Classes;

use App;
use Input;
use Auth;
Use Request;
use Response;
use Exception;
use Harryfurnish\Philterplugin\Models\Image as ImageModel;
use Harryfurnish\Philterplugin\Models\Tag as TagModel;
use RainLab\User\Models\User as UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class Api
{
	/**
	 * The JWT token to be returned 
	 * as a custom header
	 * this may need to be changed to 'OPAPITOKEN'
	 */
	public $token = '';

	
	/**
	 * Method that accepts $_POST login data 
	 * and tries to log in the user. 
	 * On success it returns a message with a JWT token.
	 *
	 * @request GET (Params: 'login' :email, 'password':password) 
     * @return JWT token (Bearer token) with a confirmation message
	 * 
	 */
    public function login()
    {
		$login = Input::get('login');
		$password = Input::get('password');
		try{
			$user = Auth::authenticate([
				'login' => $login,
				'password' => $password
			]);
			$this->setToken($user);
			return $this->sendResponse('You are now logged in');
		}
		catch (Exception $e) {
			return $this->sendResponse($e->getMessage());
		}
    }
	
	/**
	 * Method that accepts $_POST registration data 
	 * and tries to register the user. 
	 * On success it returns a message with a JWT token.
	 * 
	 * @request POST (Params: 'name' :name, 'email':email,  'password': password, 'id', id,  'password_confirmation': password_confirmation')
     * @return JWT token (Bearer token) with a confirmation message
	 *
	 */
    public function registerUser()
    {	
		/**
		 * Our UserModel will return an error 
		 * if the email already exists, 
		 * or if the passwords do not match
		 */
		try{
		$user = new UserModel();
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$user->password = Input::get('password');
		$user->id = Input::get('id');
		$user->password_confirmation = Input::get('password_confirmation');
		$user->save();	
		$this->setToken($user);
		return $this->sendResponse('You have been registered and are logged in');
		}
		catch (Exception $e) {
			return $this->sendResponse($e->getMessage());
		}
    }
	
	/**
	 * Method that logs out a user 
	 * by returning an expired token.
	 * 
	 * @request GET (Params: none, Header: OPAPITOKEN with JWTToken:) 
     * @return Expired JWTtoken OPAPITOKEN with a confirmation message
     *
	 */
    public function logout()
    {
		$user = $this->checkToken();
		if (is_a($user, 'RainLab\User\Models\User')) {
			$this->expireToken($user);	
	        return $this->sendResponse('You are now logged out');
			}
		return $this->sendResponse(false, 'You are not authorised to make this request');
	}

	
	/**
	 * Method that retrieve a single UserModel, 
	 * but only if it matches the logged-in JWT User id
	 * 
	 * @request GET (Params: none, Header: OPAPITOKEN with JWTToken:) 
     * @return the logged in user details
     *
	 */
    public function getUser()
    {
		$user = $this->checkToken();
		if (is_a($user, 'RainLab\User\Models\User')) {
			return $this->sendResponse(UserModel::find($user->id));
		}
		return $this->sendResponse(false, 'You are not authorised to view this user');
	}
	
	/**
	 * Method that update a UserModel from $_POST fields,
	 * but only if it matches the logged-in JWT User id
	 * 
	 * @request POST (Params: 'name' :name, 'email':email,  'password': password,, Header: OPAPITOKEN with JWTToken:) 
     * @return confirmation message
 	 */
    public function updateUser()
    {		
		$user = $this->checkToken();
		if ($user) {	
			try{
				$user->name = Input::get('name');
	//			$user->email = Input::get('email');
	//			$user->password = Input::get('password');
	//			$user->password_confirmation = Input::get('password_confirmation');
				$user->save();	
				return $this->sendResponse('Your details have been successfully updated');
				}
			catch (Exception $e) {
				return $this->sendResponse($e->getMessage());
			}
		return $this->sendResponse('You are not authorised to update this account');
		}
	}

/*		if ($user) {	
			$userModel = UserModel::find($user->id);
			$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$userModel->fill($data);
			$userModel->save();
			return $this->sendResponse('Your details have been successfully updated');
		}
		return $this->sendResponse('You are not authorised to update this account');
    }
*/
	/**
	 * Method that deletes a UserModel and logs out the user by expiring their token $_POST ,
	 * but only if it matches the logged-in JWT User id
	 * 
  	 * @request POST (Params: none, Header: OPAPITOKEN with JWTToken:) 
     * @return a confirmation message and expired JWT token
	 */
    public function deleteUser()
    {		
		$user = $this->checkToken();
		$userModel = UserModel::find($user->id);
		if ($user) {	
			$userModel->delete();
			$this->expireToken($userModel);
			return $this->sendResponse('Your account has been deleted');
		}
		return $this->sendResponse('You are not authorised to delete this account');
    }
	
	/**
 	 * Method that returns an array of all images  $_GET,
	 * 
  	 * @request GET (Params: none) 
     * @return an array of images
 	 */
    public function getImages()
    {
	//	$user = $this->checkToken();
		$data = [];
	//	if (is_a($user, 'RainLab\User\Models\User')) {
			$data = ImageModel::get();
			return $this->sendResponse($data);
	}
	//	return $this->sendResponse('There are no images for this user');
 //   }
	
	/**
 	 * Method that returns a single image $_GET,
	 * 
  	 * @request GET (Params: image_id, Header: OPAPITOKEN with JWTToken:) 
     * @return a single image
	 * 
 	 */
    public function getImage($image_id)
    {
  		$user = $this->checkToken();
		$data = [];
		if (is_a($user, 'RainLab\User\Models\User')) {
			$data = ImageModel::find($image_id);
			return $this->sendResponse($data);
		}
		return $this->sendResponse('There are no images for this user');
	}
	/**
	 * Method that accepts $_POST and $_FILE data 
	 * and tries to add a new image
     *
	 * @request POST (Params: 'id':id, 'name' :name, 'description': description, 'user_id', user_id,  'filter': filter, Header: OPAPITOKEN with JWTToken:)
     * @return confirmation message
	 */
    public function addImage()
    {
		$user = $this->checkToken();
		if ($user) {
			$image = new ImageModel();
			$image->id = Input::get('id');
			$image->name = Input::get('name');
			$image->description = Input::get('description');
			$image->user_id = Input::get('user_id');
			$image->filter = Input::get('filter');
			$image->save();
			//$this->saveImageModel($image, $user);
			return $this->sendResponse('Your image has been successfully uploaded');
		}
		return $this->sendResponse('You are not authorised to add an image');
    }
	
	/**
	 * Method that accepts $_PUT 
	 * and tries to update an existing image
	 * 
	 * @request PUT (Params: 'image_id':image_id, 'name' :name, 'description': description,  'filter': filter, Header: OPAPITOKEN with JWTToken:)
     * @return confirmation message
	 */
    public function updateImage($image_id)
    {			
		/**
		 * Validate that we have 
		 * a logged-in user
		 */
		$user = $this->checkToken();
		if ($user) {
			/**
			 * Only this user should be 
			 * updating this image
			 */
			$userModel = UserModel::find($user->id);		
			
			$image = ImageModel::get($userModel->user_id)->find($image_id);

		//	$image = ImageModel::usersImages($user->id)->find($image_id);
			$image->name = Input::get('name');
			$image->description = Input::get('description');
			$image->filter = Input::get('filter');
			$image->save();
		//	$this->saveImageModel($image, $user);
			return $this->sendResponse('Your image has been successfully updated');
			
		}
		return $this->sendResponse('You are not authorised to update this image');
    }
	
	/**
	 * Method that deletes an existing image $GET
	 * 
     * @param $image_id the id of the desried ImageModel
	 * @request GET (Params: 'image_id':image_id Header: OPAPITOKEN with JWTToken:)
     * @return confirmation message
	 */
    public function deleteImage($image_id)
    {			
		/**
		 * Validate that we have 
		 * a logged-in user
		 */
		$user = $this->checkToken();
		if ($user) {
			/**
			 * Only this user should be 
			 * updating this image
			 */
			$image = ImageModel::usersImages($user->id)->find($image_id);
			if ($image) {
				$image->delete();
				return $this->sendResponse('Your image has been successfully deleted');
			}
		}
		return $this->sendResponse('You are not authorised to delete this image');
    }
		
		
	/**
	 * Method that either creates or saves an ImageModel 
	 * called by other APImethos in this class
	 * 
     * @param $image ImageModel either a blank or existing model
     * @param $user logged-in UserModel
	 * 
     * @return void
	 */
	private function saveImageModel($image, $user)
	{				
		$image->name = Input::get('name');
		$image->description = Input::get('description');
		$image->filter = Input::get('filter');
		$image->image = Input::file('file');
		$tags = Input::get('tags');
		$tag_array = explode(', ', $tags); //split string into array seperated by ', '
		$tag_models = [];
		$image->save();
		foreach ($tag_array as $tag) {
			$tag = ucfirst(strtolower(trim($tag)));
			$tag_model = TagModel::where('tag', $tag)->first();
			if (!$tag_model || 
				($tag_model && !$image->tags->contains($tag_model->id))) {
				$tag_models[] = TagModel::getTag($tag);
			}
		}
		$image->tags()->attach($tag_models);
		$image->user = $user;
		$image->save();
	}
 	/*
	 * Method that retrieves all images for the logged in user $GET
	 * 
	 * @request GET (Params: none, Header: OPAPITOKEN with JWTToken:) 
     * @return an array of images
	 */
    public function getUserImages()
    {
		$user = $this->checkToken();
		$data = [];
		if (is_a($user, 'RainLab\User\Models\User')) {
				$userModel = UserModel::find($user->id);		
				$data = ImageModel::get($userModel->user_id);
			return $this->sendResponse($data);
		}
		return $this->sendResponse('There are no images for this user');
    }
	
	/**
	 * Wrapper function for JWTAuth's AddJWTToken
	 */
    private function setToken(UserModel $user)
    {
		$this->token = JWTAuth::AddJWTToken($user);
	}

	/**
	 * Wrapper function for JWTAuth's ExpireJWTToken
	 */
    private function expireToken(UserModel $user)
    {
		$this->token = JWTAuth::ExpireJWTToken($user);
	}

	/**
	 * Wrapper function for JWTAuth's CheckJWTToken
	 */
/*	  private function checkToken()
    {
		try {
			$user = JWTAuth::GetJWTUser();
			if (is_a($user, 'RainLab\User\Models\User')) {
				$this->token = JWTAuth::CheckJWTToken($user->id);
				return $user;
			} else {
				return false;
			}
        } catch (\UnexpectedValueException $e) {
            return $this->sendResponse(false, $e->getMessage());
        }
    }
*/ 
    private function checkToken()
    {
		try {
			$user = JWTAuth::GetJWTUser();
			$this->token = JWTAuth::CheckJWTToken($user->id);
            return $user;
        } catch (\UnexpectedValueException $e) {
            return $this->sendResponse($e->getMessage());
        }
    }
	
	/**
	 * JSON encode response and 
	 * include the token
	 */
	private function sendResponse($data, $error=false)
	{
		if ($error) {
			return Response::json($error, '401');
		}
		return Response::json($data)->header('Authorization', 'Bearer ' . $this->token);
	}

}
