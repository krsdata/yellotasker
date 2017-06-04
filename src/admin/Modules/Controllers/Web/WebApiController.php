<?php
namespace Admin\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Admin\Helpers\Helper as Helper;

 
class WebApiController extends Controller
{
		 
		 
		private $user_id;
		 

		public function __construct(g Request $request)
		{
			 
		} 
  	
  		public function test()
  		{
  			echo "test";
  		}
	
} 