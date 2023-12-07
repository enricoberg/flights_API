<?php

require_once 'core/Router.php';
require_once 'core/Request.php';
require_once 'core/Response.php';

use App\Core\Router as Router; 
use App\Core\Request as Request; 
use App\Core\Response as Response; 

Router::load('routes.php')->direct(Request::uri(), Request::method());


?>