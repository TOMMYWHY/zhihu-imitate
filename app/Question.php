<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

	/**
	 * @var array
	 */
	protected $fillable =['title','body','user_id'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function topics() {
		return $this->belongsToMany(Topic::class,'question_topic')->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo( User::class);
	}

	public function scopePublished( $query ) {
		return $query->where('is_hidden','F');
	}
}
