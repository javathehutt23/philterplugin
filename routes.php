<?php

/**
 * Class to filer requests to the required methods.
 */
$api = new Harryfurnish\Philterplugin\Classes\Api();
// LOGIN
//	 @request GET (Params: 'login' :email, 'password':password) 
//   @return JWT token (Bearer token) with a confirmation message
Route::post('api/v1/login', function() use ($api) {
    return $api->login();
});

// REGISTERUSER
//	 @request POST (Params: 'name' :name, 'email':email,  'password': password, 'id', id,  'password_confirmation': password_confirmation')
//   @return JWT token (Bearer token) with a confirmation message
Route::post('api/v1/users/registeruser', function() use ($api) {
    return $api->registerUser();
});

//LOGOUT
//	 @request GET (Params: none, Header: OPAPITOKEN with JWTToken:) 
//   @return Expired JWTtoken OPAPITOKEN with a confirmation message
Route::get('api/v1/logout', function() use ($api) {
    //TODO Login 4. call the correct Api method
	return $api->logout();
});

//USERS
//   @request GET (Params: none, Header: OPAPITOKEN with JWTToken:) 
//   @return the logged in user details
Route::get('api/v1/users', function() use ($api) {
    return $api->getUser();
});

// UPDATE
//   @request POST (Params: 'name' :name, 'email':email,  'password': password,, Header: OPAPITOKEN with JWTToken:) 
//   @return confirmation message
Route::post('api/v1/users/update', function() use ($api) {
    return $api->updateUser();
});

//DELETE
//   @request POST (Params: none, Header: OPAPITOKEN with JWTToken:) 
//   @return a confirmation message and expired JWT token
Route::post('api/v1/users/delete', function() use ($api) {
    return $api->deleteUser();
});

// GETIMAGES
// 	 @request GET (Params: none, Header: OPAPITOKEN with JWTToken:) 
//   @return an array of images
Route::get('api/v1/getimages', function() use ($api) {
    return $api->getImages();
});

// GETIMAGES
// 	  @request GET (Params: image_id, Header: OPAPITOKEN with JWTToken:) 
//    @return a single image
Route::get('api/v1/images/getimage', function() use ($api) {
	 $image_id =  Input::get('image_id');
    return $api->getImage($image_id);
});

// GETUSERIMAGES
// 	 @request GET (Params: none, Header: OPAPITOKEN with JWTToken:) 
//   @return an array of images
Route::get('api/v1/images/user', function() use ($api) {
    return $api->getUserImages();
});

// ADD
//	 @request POST (Params: 'id':id, 'name' :name, 'description': description, 'user_id', user_id,  'filter': filter, Header: OPAPITOKEN with JWTToken:)
//   @return confirmation message
Route::post('api/v1/images/add', function() use ($api) {
    return $api->addImage();
});

// UPDATE
// 	 @request PUT (Params: 'image_id':image_id, 'name' :name, 'description': description,  'filter': filter, Header: OPAPITOKEN with JWTToken:)
//   @return confirmation message
Route::put('api/v1/images/update', function() use ($api) {
    $image_id =  Input::get('image_id');
	return $api->updateImage($image_id);
});

// DELETE
//     @param $image_id the id of the desried ImageModel
//	   @request GET (Params: 'image_id':image_id Header: OPAPITOKEN with JWTToken:)
//     @return confirmation message

Route::get('api/v1/images/delete', function() use ($api) {
	 $image_id =  Input::get('image_id');
    return $api->deleteImage($image_id);
});