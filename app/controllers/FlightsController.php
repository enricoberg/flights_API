<?php

namespace App\App\Controllers;
require_once "./core/Database.php";
require_once "./core/Query.php";
require_once "./app/models/flights.php";
use App\Core\Query as Query;
use App\Models\Flights as Flights;
use App\Core\Response;

class FlightsController
{
  public static function getFlights()
  {
    $uri_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $queryObject = new Query();
    if (count($uri_parts) === 2 && is_numeric($uri_parts[1])) $result = $queryObject->get(Flights::getFlight($uri_parts[1]));
    else if(count($uri_parts) === 1){
      $result = $queryObject->get(Flights::getFlights());
    }
    Response::message("WRONG QUERY", 400);
    
    
  }
  public static function addFlight(){
    $queryObject = new Query();
    $result = $queryObject->post(Flights::addFlight());
  }
  public static function patchFlight(){
    $request_uri = $_SERVER['REQUEST_URI'];
    $queryObject = new Query();
    $uri_parts = explode('/', trim($request_uri, '/'));
    if (count($uri_parts) == 2 && is_numeric($uri_parts[1])) $result = $queryObject->patch(Flights::patchFlight($uri_parts[1]));
    Response::message("The input you provided is not valid. The request to patch should include the numeric ID of the flight, e.g. /flights/13. The parameters to change must be sent as headers of the request", 400);
    
  }

  public static function deleteFlight(){
    $request_uri = $_SERVER['REQUEST_URI'];
    $uri_parts = explode('/', trim($request_uri, '/'));  
    $queryObject = new Query();
    if (count($uri_parts) != 2 || !is_numeric($uri_parts[1]))  Response::message("he input you provided is not valid. The request to delete should include the numeric ID of the flight, e.g. /flights/13", 400);
    $result = $queryObject->delete(Flights::deleteFlight($uri_parts[1]));
  }

}
?>