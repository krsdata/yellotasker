<?php

namespace App\Http\Middleware;

use Closure;
use Request; 
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
   /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    
    protected function excludedRoutes($request)  
	{ 

		$path_info_url = $request->getpathinfo(); 

		if (strpos($path_info_url, 'api/v1') !== false) {
		    $path_info_url  = $path_info_url;
		} 
 		
	    $routes = [
	            ltrim($path_info_url,'/'),  
	    ]; 

	    foreach($routes as $route)
	        if ($request->is($route))
	            return true;
	        return false;
	}

    public function handle($request, Closure $next)  
    {
    	 
            // Allow request that come from API only
        if ($this->isReading($request) || $this->excludedRoutes($request) || $this->tokensMatch($request))
        {
             return $this->addCookieToResponse($request, $next($request));
        }

        throw new TokenMismatchException;
    }
     /**
     * Add the CSRF token to the response cookies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Http\Response
     */
    
}
