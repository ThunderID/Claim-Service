<?php

namespace App\Entities;

use App\Entities\Observers\ClaimObserver;

/**
 * Used for Claim Models
 * 
 * @author cmooy
 */
class Claim extends BaseModel
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $collection			= 'mt_claim';

	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at'];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable				=	[
											'title'							,
											'reference_id'					,
											'accident'						,
											'issued'						,
										];
										
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'title'							=> 'required|max:255',
											'reference_id'					=> 'required|max:255',
											'accident.date'					=> 'required|date_format:"Y-m-d H:i:s"',
											'accident.place'				=> 'required',
											'accident.details'				=> 'required',
											'issued.at'						=> 'required|date_format:"Y-m-d H:i:s"',
											'issued.by._id'					=> 'required',
											'issued.by.name'				=> 'required',
											'issued.to._id'					=> 'required',
											'issued.to.name'				=> 'required',
										];


	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- FUNCTIONS ----------------------------------------------------------------------------*/
		
	/**
	 * boot
	 * observing model
	 *
	 */
	public static function boot() 
	{
        parent::boot();

		Claim::observe(new ClaimObserver);
    }

	/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/

	/**
	 * scope to get condition where owner id
	 *
	 * @param string or array of owner id
	 **/
	public function scopeOwner($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('issued.to._id', $variable);
		}

		return $query->where('issued.to._id', 'regexp', '/^'. preg_quote($variable) .'$/i');
	}
}
