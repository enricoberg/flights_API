<?php

namespace App\App\Controllers;
require_once "./core/Database.php";
require_once "./core/Query.php";
require_once "./app/models/book.php";
use App\Core\Query as Query;
use App\Models\Book as Book;
use App\Core\Response;

class BookController
{
    public static function getBooking()
    {
       $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        parse_str($queryString, $params);
        $id = isset($params['id']) ? $params['id'] : null;
        $seats = isset($params['seats']) ? (int)$params['seats'] : null;
        if ($id==null || $seats ==null ) Response::message("Id of the flight and number of seats are mandatory",400);
        // CHECK THE NUMBER OF AVAILABLE SEATS FOR THE SELECTED FLIGHT
        $queryObject = new Query();        
        $result = $queryObject->getRaw("SELECT AVAILABLE_SEATS FROM FLIGHTS WHERE ID=$id");
        $availables=(int)$result[0]["AVAILABLE_SEATS"];
        if($availables>=$seats) $result = $queryObject->patch(Book::getBooking($id,$availables,$seats));
        Response::message("Oops, looks like there are not enough available seats",400);

    }   
        
      
}


?>