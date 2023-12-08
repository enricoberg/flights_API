<?php

$router->get('flights', 'FlightsController@getFlights');
$router->post('flights', 'FlightsController@addFlight');
$router->patch('flights', 'FlightsController@patchFlight');
$router->delete('flights', 'FlightsController@deleteFlight');
$router->get('locations', 'LocationsController@getLocations');
$router->post('locations', 'LocationsController@addLocation');
$router->patch('locations', 'LocationsController@patchLocation');
$router->delete('locations', 'LocationsController@deleteLocation');







?>