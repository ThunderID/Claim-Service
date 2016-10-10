<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\Claim as Model; 

/**
 * Used in CLient model
 *
 * @author cmooy
 */
class ClaimObserver 
{
	public function saving($model)
	{
		return true;
	}
}
