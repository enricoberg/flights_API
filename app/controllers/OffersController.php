<?php

namespace App\App\Controllers;

require_once "./core/Database.php";
require_once "./core/Query.php";
require_once "./app/models/offers.php";

use App\Core\Query as Query;
use App\Models\Offers as Offers;
use App\Core\Response;

class OffersController
{
    public static function getOffers()
    {
        $uri_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $queryObject = new Query();
        if (count($uri_parts) === 2 && is_numeric($uri_parts[1])) $result = $queryObject->get(Offers::getOffer($uri_parts[1]));
        else if (count($uri_parts) === 1) {
            $result = $queryObject->get(Offers::getOffers());
        }
        Response::message("WRONG QUERY", 400);
    }
    public static function addOffer()
    {
        $queryObject = new Query();
        $result = $queryObject->post(Offers::addOffer());
    }

    public static function patchOffer()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        $queryObject = new Query();
        $uri_parts = explode('/', trim($request_uri, '/'));
        if (count($uri_parts) == 2 && is_numeric($uri_parts[1])) $result = $queryObject->patch(Offers::patchOffer($uri_parts[1]));
        Response::message("The input you provided is not valid. The request to patch should include the numeric ID of the offer, e.g. /offers/2. The parameters to change must be sent as headers of the request", 400);
    }
    public static function deleteOffer()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        $uri_parts = explode('/', trim($request_uri, '/'));
        $queryObject = new Query();
        if (count($uri_parts) != 2 || !is_numeric($uri_parts[1]))  Response::message("The input you provided is not valid. The request to delete should include the numeric ID of the offer, e.g. /offers/2", 400);
        $result = $queryObject->delete(Offers::deleteOffer($uri_parts[1]));
    }
}
