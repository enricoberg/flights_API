<?php
namespace App\Models;
use App\Core\Response;

class Flights{
    public static function getFlights(){
        $uri_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        //GET THE BASE QUERY
        $query_base=file_get_contents(__DIR__ . '/../../core/mysql/get_flights_query.txt');        
        //EXTRACT ALL THE FILTERS FROM THE QUERY STRING
        $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        parse_str($queryString, $params);
        $arrival = isset($params['arrival']) ? $params['arrival'] : null;
        $departure = isset($params['departure']) ? $params['departure'] : null;
        $company=isset($params['company']) ? $params['company'] : null;
        $status=isset($params['status']) ? $params['status'] : null;
        $price=isset($params['cheaper-than']) ? $params['cheaper-than'] : null;        
        $availableseats= isset($params['available-seats']) ? $params['available-seats'] : null;
        $exactdate = isset($params['date']) ? $params['date'] : null;
        if($exactdate!=null)    $exactdate = \DateTime::createFromFormat('Y-m-d', $exactdate)->format('Y-m-d');      
        $datefrom= isset($params['date-from']) ? $params['date-from'] : null;
        if($datefrom!=null)     $datefrom = \DateTime::createFromFormat('Y-m-d', $datefrom)->format('Y-m-d');     
        $dateto = isset($params['date-to']) ? $params['date-to'] : null;
        if($dateto!=null)       $dateto = \DateTime::createFromFormat('Y-m-d', $dateto)->format('Y-m-d');
        //ADD ALL THE FILTERS INSERTED TO THE QUERY
        if (!count($params) == 0){                
            $array_filters = [];
            if($departure != null) array_push($array_filters, "f.DEP_AIRPORT = '".$departure."' ");
            if($arrival != null) array_push($array_filters, "f.ARR_AIRPORT ='".$arrival."' ");
            if($company != null) array_push($array_filters, "f.FLIGHT_COMPANY ='".$company."' ");
            if($status != null) array_push($array_filters, "f.STATUS ='".$status."' ");
            if($availableseats != null) array_push($array_filters, "f.AVAILABLE_SEATS >=".$availableseats." ");
            if($price != null) array_push($array_filters, "COALESCE(f.price * (1-o.discount/100), f.price) <".$price." ");
            if($exactdate != null && $datefrom==null && $dateto==null) array_push($array_filters, "DATE(DATE_ADD(f.time_dep, INTERVAL t1.timezone HOUR)) ='".$exactdate."' ");
            if($exactdate == null && $datefrom!=null && $dateto!=null) array_push($array_filters, "DATE(DATE_ADD(f.time_dep, INTERVAL t1.timezone HOUR)) BETWEEN '".$datefrom."' AND '".$dateto."'");
            if($exactdate == null && $datefrom!=null && $dateto==null) array_push($array_filters, "DATE(DATE_ADD(f.time_dep, INTERVAL t1.timezone HOUR)) > '".$datefrom."'");
            if($exactdate == null && $datefrom==null && $dateto!=null) array_push($array_filters, "DATE(DATE_ADD(f.time_dep, INTERVAL t1.timezone HOUR))  < '".$dateto."'");
            $conditions = implode(" AND ", $array_filters);
            if(count($array_filters)>0) $query_base.= " WHERE ".$conditions;            
        }        
        return $query_base;
    }
    public static function getFlight($id){        
        $query_base=file_get_contents(__DIR__ . '/../../core/mysql/get_flights_query.txt');
        // ADD THE ID OF A SPECIFIC FLIGHT 
        $query_base=$query_base.' WHERE f.ID ='.$id;
        return $query_base;
    }
    public static function addFlight(){
        //EXTRACT ALL THE DATA ABOUT THE FLIGHT
        $departure = isset($_POST['departure']) ? $_POST['departure'] : null;
        $arrival = isset($_POST['arrival']) ? $_POST['arrival'] : null;
        $time_departure = isset($_POST['time-departure']) ? $_POST['time-departure'] : null;
        $time_arrival = isset($_POST['time-arrival']) ? $_POST['time-arrival'] : null;
        $flight_company = isset($_POST['flight-company']) ? $_POST['flight-company'] : null;
        $max_seats = isset($_POST['max-seats']) ? $_POST['max-seats'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;    
        $SEATS_INDICATED=($max_seats==null)? " " : "AVAILABLE_SEATS, MAX_SEATS, ";
        $SEATS_VALUE=($max_seats==null)? "" : $max_seats.", ".$max_seats.", ";    
        //CREATE THE BASE QUERY
        $base_query="INSERT INTO FLIGHTS (DEP_AIRPORT, ARR_AIRPORT, TIME_DEP, TIME_ARR, FLIGHT_COMPANY,";
        //ADD THE VALUES TO THE QUERY
        if($departure!=null && $arrival!=null && $time_departure!=null && $time_arrival!=null && $flight_company!=null && $price!=null) {
            $base_query= $base_query." $SEATS_INDICATED PRICE) VALUES ('$departure', '$arrival', '$time_departure', '$time_arrival', '$flight_company', $SEATS_VALUE  $price)";
            return $base_query;
        }  
        Response::message("Missing data, impossible to create new instance of travel. Please send the value of the parameters as key-value pairs in the body of the request", 400);
        }
    public static function patchFlight($id){
        $headers = getallheaders();                             
        //GET ALL THE PARAMETERS FROM THE HEADERS OF THE REQUEST        
        $departure = isset($headers['departure']) ? $headers['departure'] : null;
        $arrival = isset($headers['arrival']) ? $headers['arrival'] : null;
        $time_departure = isset($headers['time-departure']) ? $headers['time-departure'] : null;
        $time_arrival = isset($headers['time-arrival']) ? $headers['time-arrival'] : null;
        $flight_company = isset($headers['flight-company']) ? $headers['flight-company'] : null;
        $max_seats = isset($headers['max-seats']) ? $headers['max-seats'] : null;
        $available = isset($headers['available-seats']) ? $headers['available-seats'] : null;
        $price = isset($headers['price']) ? $headers['price'] : null;
        $status=isset($headers['status']) ? $headers['status'] : null;
        // CREATE THE CUSTOM QUERY
        $array_properties = [];
        if($departure != null) array_push($array_properties, "DEP_AIRPORT = '".$departure."' ");
        if($arrival != null) array_push($array_properties, "ARR_AIRPORT = '".$arrival."' ");
        if($time_departure != null) array_push($array_properties, "TIME_DEP ='".$time_departure."' ");
        if($time_arrival != null) array_push($array_properties, "TIME_ARR ='".$time_arrival."' ");
        if($price != null) array_push($array_properties, "PRICE =".$price." ");
        if($flight_company != null) array_push($array_properties, "FLIGHT_COMPANY ='".$flight_company."' ");
        if($status != null) array_push($array_properties, "STATUS ='".$status."' ");
        if($max_seats != null) array_push($array_properties, "MAX_SEATS =".$max_seats." ");
        if($available != null) array_push($array_properties, "AVAILABLE_SEATS =".$available." ");
        $conditions = implode(" , ", $array_properties);  
        if (!count($array_properties)>0) Response::message("No parameter to change was provided. The request to patch should include the numeric ID of the flight, e.g. /flights/13. The parameters to change must be sent as headers of the request", 400);
        $base_query="UPDATE FLIGHTS SET $conditions WHERE ID =".$id;
        return $base_query;

    }
    public static function deleteFlight($id){
        $base_query="DELETE FROM FLIGHTS WHERE ID =$id ";
        return $base_query;
    }
    
    


}





?>