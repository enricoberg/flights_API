<?php
namespace App\Core;
use App\Core\Response;
use App\Core\Database as Database;

class Query{
    //METHOD FOR HANDLING GET REQUESTS AND SENDING THE CORRECT STATUS WITH THE RESPONSE
    public static function get($query_string){
        $database = new Database();
        $connection = $database->connection();        
        try{
            $result = mysqli_query($connection, $query_string);
            $emparray = array();
            while($row =mysqli_fetch_assoc($result))    $emparray[] = $row;            
            if(empty($emparray))  Response::message("NO RESULTS FOUND", 404);
            else                  Response::json($emparray, 200);        
        
        }
        catch(\Exception $e) { Response::message("WRONG QUERY", 400); }
    
    mysqli_close($connection);
    }
    //METHOD FOR HANDLING POST REQUESTS AND SENDING THE CORRECT STATUS WITH THE RESPONSE
    function post($query_string){    
        $database = new Database();
        $connection = $database->connection();  
        try{
            if ($connection->query($query_string)) {
                $numberUpdates= $connection->affected_rows;                
                if($numberUpdates!=0) Response::message("New record created successfully", 201);  
                else{
                    Response::message("Impossible to create this record", 400);  
                    return;
                }
            }
            }         
        catch(\Exception $e){ Response::message("Error creating new record: $e", 200); }      
        mysqli_close($connection);
    }
    //METHOD FOR HANDLING PATCH REQUESTS AND SENDING THE CORRECT STATUS WITH THE RESPONSE
    function patch($query_string){
        $database = new Database();
        $connection = $database->connection();          
        try{
            if ($connection->query($query_string)) {            
                $numberUpdates= $connection->affected_rows;                
                if($numberUpdates==0)  Response::message("No record found", 404);  
                else   Response::message("Record updated successfully", 200);
              }         
        }
        catch (\Exception $e) {
            Response::message("Error updating record: $e", 400);                    
        }
        mysqli_close($connection);
    }
    //METHOD FOR HANDLING DELETE REQUESTS AND SENDING THE CORRECT STATUS WITH THE RESPONSE
    function delete($query_string){
        $database = new Database();
        $connection = $database->connection();  
        try{
            if ($connection->query($query_string)) {            
                $numberUpdates= $connection->affected_rows;                
                if($numberUpdates==0) Response::message("Impossible to delete. No such record.", 404); 
                else    Response::message("Record deleted successfully", 200); 
               }         
        }
        catch (\Exception $e) {
                    Response::message("Error deleting record: $e", 400); 
                            }
        mysqli_close($connection);
    }
}




?>