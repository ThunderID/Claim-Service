<?php

namespace App\Http\Controllers;

use App\Libraries\JSend;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Entities\Claim;

/**
 * Claim  resource representation.
 *
 * @Resource("Claim", uri="/claims")
 */
class ClaimController extends Controller
{
	public function __construct(Request $request)
	{
		$this->request 				= $request;
	}

	/**
	 * Show all claims
	 *
	 * @Get("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"search":{"_id":"string","owner":"string"},"sort":{"newest":"asc|desc","title":"desc|asc"}, "take":"integer", "skip":"integer"}),
	 *      @Response(200, body={"status": "success", "data": {"data":{"_id":"string","title":"string","reference_id":"string","accident":{"date":"string","place":"string","details":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}},"count":"integer"} })
	 * })
	 */
	public function index()
	{
		$result						= new Claim;

		if(Input::has('search'))
		{
			$search					= Input::get('search');

			foreach ($search as $key => $value) 
			{
				switch (strtolower($key)) 
				{
					case '_id':
						$result		= $result->id($value);
						break;
					case 'owner':
						$result		= $result->ownerid($value);
						break;
					default:
						# code...
						break;
				}
			}
		}

		if(Input::has('sort'))
		{
			$sort					= Input::get('sort');

			foreach ($sort as $key => $value) 
			{
				if(!in_array($value, ['asc', 'desc']))
				{
					return response()->json( JSend::error([$key.' harus bernilai asc atau desc.'])->asArray());
				}
				switch (strtolower($key)) 
				{
					case 'newest':
						$result		= $result->orderby('created_at', $value);
						break;
					default:
						# code...
						break;
				}
			}
		}
		else
		{
			$result		= $result->orderby('created_at', 'asc');
		}

		$count						= count($result->get());

		if(Input::has('skip'))
		{
			$skip					= Input::get('skip');
			$result					= $result->skip($skip);
		}

		if(Input::has('take'))
		{
			$take					= Input::get('take');
			$result					= $result->take($take);
		}

		$result 					= $result->get();
		
		return response()->json( JSend::success(['data' => $result->toArray(), 'count' => $count])->asArray())
				->setCallback($this->request->input('callback'));
	}

	/**
	 * Store Claim
	 *
	 * @Post("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"_id":"string","title":"string","reference_id":"string","accident":{"date":"string","place":"string","details":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}}),
	 *      @Response(200, body={"status": "success", "data": {"_id":"string","title":"string","reference_id":"string","accident":{"date":"string","place":"string","details":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}}}),
	 *      @Response(200, body={"status": {"error": {"code must be unique."}}})
	 * })
	 */
	public function post()
	{
		$id 			= Input::get('_id');

		if(!is_null($id) && !empty($id))
		{
			$result		= Claim::id($id)->first();
		}
		else
		{
			$result 	= new Claim;
		}
		

		$result->fill(Input::only('title', 'reference_id', 'accident', 'issued'));

		if($result->save())
		{
			return response()->json( JSend::success($result->toArray())->asArray())
					->setCallback($this->request->input('callback'));
		}
		
		return response()->json( JSend::error($result->getError())->asArray());
	}

	/**
	 * Delete Claim
	 *
	 * @Delete("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"id":null}),
	 *      @Response(200, body={"status": "success", "data": {"_id":"string","title":"string","reference_id":"string","accident":{"date":"string","place":"string","details":"string"},"issued":{"at":"datetime","by":{"_id":"string","name":"string"},"to":{"_id":"string","name":"string"}}}}),
	 *      @Response(200, body={"status": {"error": {"code must be unique."}}})
	 * })
	 */
	public function delete()
	{
		$claim 			= Claim::id(Input::get('_id'))->first();
		
		$result 		= $claim;

		if($claim && $claim->delete())
		{
			return response()->json( JSend::success($result->toArray())->asArray())
					->setCallback($this->request->input('callback'));
		}

		if(!$claim)
		{
			return response()->json( JSend::error(['ID tidak valid'])->asArray());
		}

		return response()->json( JSend::error($claim->getError())->asArray());
	}
}