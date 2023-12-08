<?php

namespace App\App\Controllers;

require_once "./core/Database.php";
require_once "./core/Query.php";
require_once "./app/models/locations.php";

use App\Core\Query as Query;
use App\Models\Locations as Locations;
use App\Core\Response;

class LocationsController
{
  public static function getLocations()
  {
    $uri_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $queryObject = new Query();
    if (count($uri_parts) === 2) $result = $queryObject->get(Locations::getLocation($uri_parts[1]));
    else if (count($uri_parts) === 1) {
      $result = $queryObject->get(Locations::getLocations());
    }
    Response::message("WRONG QUERY", 400);
  }

  public static function addlocation()
  {
    $queryObject = new Query();
    $result = $queryObject->post(Locations::addLocation());
  }

  public static function patchLocation()
  {
    $request_uri = $_SERVER['REQUEST_URI'];
    $queryObject = new Query();
    $uri_parts = explode('/', trim($request_uri, '/'));
    if (count($uri_parts) == 2) $result = $queryObject->patch(Locations::patchLocation($uri_parts[1]));
    Response::message("The input you provided is not valid. The request to patch should include the ID of the airport, e.g. /locations/lin. The parameters to change must be sent as headers of the request", 400);
  }
  public static function deleteLocation()
  {
    $request_uri = $_SERVER['REQUEST_URI'];
    $uri_parts = explode('/', trim($request_uri, '/'));
    $queryObject = new Query();
    if (count($uri_parts) != 2)  Response::message("The input you provided is not valid. The request to delete should include the ID of the airport, e.g. /locations/lin", 400);
    $result = $queryObject->delete(Locations::deleteLocation($uri_parts[1]));
  }
}
