<?php
namespace App\Models;
use App\Core\Response;
class Locations{

    public static function getLocations(){
        //GET THE BASE QUERY
        $base_query="SELECT * FROM LOCATIONS";
        $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        //EXTRACT ALL THE FILTERS FROM THE QUERY STRING
        parse_str($queryString, $params);
        $city = isset($params['city']) ? $params['city'] : null;
        $country = isset($params['country']) ? $params['country'] : null;
        if(count($params)==0) return $base_query;
        //ADD ALL THE FILTERS INSERTED TO THE QUERY
        $array_filters = [];
        if($city != null) array_push($array_filters, "CITY = '".$city."' ");
        if($country != null) array_push($array_filters, "COUNTRY ='".$country."' ");        
        $conditions = implode(" AND ", $array_filters);
        if(count($array_filters)>0) $base_query.= " WHERE ".$conditions;
        return $base_query;
    }
    public static function getLocation($id){        
        return "SELECT * FROM LOCATIONS WHERE AIRPORT ='".$id."'";
    }
    public static function addLocation(){
        //EXTRACT ALL THE DATA ABOUT THE LOCATION
        $airport= isset($_POST['airport']) ? strtoupper($_POST['airport']) : null;
        $city = isset($_POST['city']) ? $_POST['city'] : null;
        $country= isset($_POST['country']) ? $_POST['country'] : null;
        $timezone = isset($_POST['timezone']) ? $_POST['timezone'] : null;    
        if($airport!=null && $city!=null && $country!=null && $timezone!=null )  return "INSERT INTO LOCATIONS (AIRPORT, CITY, COUNTRY, TIMEZONE) VALUES ('$airport', '$city', '$country', $timezone)";
        Response::message("Missing data, impossible to create new instance of location. Please send the value of the parameters as key-value pairs in the body of the request",400);           
    }
    public static function patchLocation($id){
        $request_uri = $_SERVER['REQUEST_URI'];
        $uri_parts = explode('/', trim($request_uri, '/'));      
        $headers = getallheaders();                             
        //GET ALL THE PARAMETERS FROM THE HEADERS OF THE REQUEST            
        $city = isset($headers['city']) ? $headers['city'] : null;
        $country = isset($headers['country']) ? $headers['country'] : null;
        $timezone = isset($headers['timezone']) ? $headers['timezone'] : null;            
        // CREATE THE CUSTOM QUERY
        $array_properties = [];
        if($city != null) array_push($array_properties, "CITY = '".$city."' ");
        if($country != null) array_push($array_properties, "COUNTRY = '".$country."' ");
        if($timezone != null) array_push($array_properties, "TIMEZONE= ".$timezone." ");
        $conditions = implode(" , ", $array_properties);            
        $base_query=(count($array_properties)>0)?  "UPDATE LOCATIONS SET $conditions WHERE AIRPORT = '$id'" : null;
        if ($base_query!=null)  return $base_query;
        Response::message("No parameter to change was provided. The request to patch should include the ID of the AIRPORT, e.g. /locations/BTC. The parameters to change must be sent as headers of the request",400);           
    }
    public static function deleteLocation($id){
        return "DELETE FROM LOCATIONS WHERE AIRPORT ='$id' ";       
    }
}

?>