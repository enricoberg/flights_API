<?php
    require_once "./core/Database.php";
    require_once "./core/Query.php";
    use App\Core\Database as Database;
    use App\Core\Query as Query;

    $query_close_booking = "UPDATE flights SET status = 'CLOSED' WHERE TIME_DEP - INTERVAL 6 HOUR < NOW() ";
    $query_close_flight = "UPDATE flights SET status = 'DEPARTED' WHERE TIME_DEP  < NOW() ";
    $query_discount_expiration = "DELETE FROM offers WHERE EXPIRATION < NOW()";
    
   
    try{
        $queryObject = new Query();
        $result = $queryObject->patch($query_close_booking);
        $result = $queryObject->patch($query_close_flight);
        $result = $queryObject->delete($query_discount_expiration);
    }
    catch(Exception $e) {
        echo "Problem on automatic query of the database";
    }



?>