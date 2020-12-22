<?php namespace HarryFurnish\Philterplugin\Models;

use Model;

/**
 * Model
 */
class Image extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'harryfurnish_philterplugin_image';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

	/*public function scopeLatest($query)
    {
        return $query->take(8)->orderBy('id', 'desc');
    };*/
    /*
     * Relations
     */
    public $belongsTo = [
        'user' => ['RainLab\User\Models\User']
    ];
    /*
     * Relations
     */
    public $attachOne = [
        'file' => ['System\Models\File']
    ];

    public $belongsToMany = [
        'tags' => [
            'harryfurnish\philterplugin\Models\Tag',
            'table' => 'harryfurnish_philterplugin_image_tag',
            'order' => 'tag'
        ]
    ];

	public function scopeLatest($query)
    {
        return $query->take(8)->orderBy('id', 'desc');
    }

	public function scopeOthersImages($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id);
    }

	public function scopeUsersImages($query, $user_id){
		return $query->where('user_id', $user_id)->orderBy('id', 'description');
	}

}
