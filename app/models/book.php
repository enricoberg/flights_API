<?php

namespace App\Models;

use App\Core\Response;

class Book
{
    public static function getBooking($id, $available, $requested)
    {


        if ($available == $requested) return "UPDATE flights SET AVAILABLE_SEATS = 0, STATUS = 'CLOSED' WHERE ID=$id";
        elseif ($available > $requested) {
            $residual_seats = $available - $requested;
            return "UPDATE flights SET AVAILABLE_SEATS = $residual_seats WHERE ID=$id";
        }
    }
}
