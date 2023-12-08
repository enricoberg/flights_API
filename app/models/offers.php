<?php
namespace App\Models;
use App\Core\Response;
class Offers{
    public static function getOffers(){
        //GET THE BASE QUERY
        $base_query="SELECT * FROM OFFERS";
         //EXTRACT ALL THE FILTERS FROM THE QUERY STRING
        $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        parse_str($queryString, $params);
        $departure = isset($params['departure']) ? $params['departure'] : null;
        $arrival = isset($params['arrival']) ? $params['arrival'] : null;
        $discount= isset($params['discount']) ? $params['discount'] : null;
        //QUERY ALL THE OFFER TABLE IF NO FILTER IS REQUESTED
        if (count($params) == 0) return $base_query;
        //MODIFY THE BASE QUERY IN CASE FILTERS ARE APPLIED  
        $base_query=file_get_contents(__DIR__ . '/../../core/mysql/get_offers_query.txt');
        $array_filters = [];
        if($departure != null) array_push($array_filters, "f.dep_airport = '".$departure."' ");
        if($arrival != null) array_push($array_filters, "f.arr_airport='".$arrival."' ");    
        if($discount != null) array_push($array_filters, "o.discount>=".$discount." ");      
        $conditions = implode(" AND ", $array_filters);
        if(count($array_filters)>0) $base_query.= " WHERE ".$conditions;          
        return $base_query;    
    }
    
    public static function getOffer($id){
        return "SELECT * FROM OFFERS WHERE ID = ".$id;
    }
    public static function addOffer(){
        $discount = isset($_POST['discount']) ? $_POST['discount'] : null;
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $expiration = isset($_POST['expiration']) ? $_POST['expiration'] : null;    
        //EXIT IF THE PARAMETERS ARE NOT SET
        if($discount==null || $id==null)  Response::message("Missing data, impossible to create new instance of offer. Please send the value of the parameters as key-value pairs in the body of the request",400);  
        //QUERY IF THE EXPIRATION IS NOT SET, DEFAULT TO 6 HOUR DIFFERENCE FROM DEPARTURE   
        if($expiration==null)   return "INSERT INTO offers (id, discount, expiration)  SELECT $id, $discount, DATE_SUB(time_dep, INTERVAL 6 HOUR)  FROM flights WHERE id = $id";
        //QUERY WITH MANUAL SETTING OF EXPIRATION
        return "INSERT INTO offers (id, discount, expiration) SELECT $id, $discount, '$expiration' FROM flights WHERE id = $id";              
    }
    public static function patchOffer($id){       
        //GET ALL THE PARAMETERS FROM THE HEADERS OF THE REQUEST
        $headers = getallheaders();  
        $discount = isset($headers['discount']) ? $headers['discount'] : null;
        $expiration = isset($headers['expiration']) ? $headers['expiration'] : null;            
        // CREATE THE CUSTOM QUERY
        $array_properties = [];
        if($discount != null) array_push($array_properties, "DISCOUNT = ".$discount." ");
        if($expiration != null) array_push($array_properties, "EXPIRATION = '".$expiration."' ");            
        $conditions = implode(" , ", $array_properties);            
        $base_query=(count($array_properties)>0)?  "UPDATE OFFERS SET $conditions WHERE ID = $id" : null;
        //SEND THE UPDATE QUERY IF PARAMETERS ARE SET CORRECTLY, OTHERWISE EXIT WITH ERROR 400
        if($base_query!=null) return $base_query;
        Response::message("No parameter to change was provided. The request to patch should include the numeric ID of the flight, e.g. /offers/13. The parameters to change must be sent as headers of the request",400);        
    }
    public static function deleteOffer($id){
        return "DELETE FROM OFFERS WHERE ID =".$id;           
    }

}

?>