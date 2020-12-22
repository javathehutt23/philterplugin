<?php namespace HarryFurnish\Philterplugin\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
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
    public $table = 'harryfurnish_philterplugin_tag';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
	
	public function scopeGetTag($query, $new_tag){
		$tag = Tag::where('tag', '=', $new_tag)->first();
		if ($tag === null) {
			$tag = new Tag();
			$tag->tag = $new_tag;
			$tag->save();
		}
		return $tag->id;
	}
}
