<?php

namespace Modules\Admin\Resources;

use Illuminate\Http\Request;
use Illuminate\Log\Writer;
use Monolog\Logger as Monolog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests; 

use Illuminate\Support\Facades\DB;

/**
 * @author amanda
 */
abstract class BaseResource {
    protected $model;
    
    public function __destruct() {
        $this->model=null;
    }

    /**
     * @return Model
     */
    protected abstract function getUserModel();

    
} 