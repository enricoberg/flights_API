<?php

$router->get('flights', 'FlightsController@getFlights');
$router->post('flights', 'FlightsController@addFlight');
$router->patch('flights', 'FlightsController@patchFlight');
$router->delete('flights', 'FlightsController@deleteFlight');
$router->get('locations', 'LocationsController@getLocations');
$router->post('locations', 'LocationsController@addLocation');
$router->patch('locations', 'LocationsController@patchLocation');
$router->delete('locations', 'LocationsController@deleteLocation');
$router->get('offers', 'OffersController@getOffers');
$router->post('offers', 'OffersController@addOffer');
$router->patch('offers', 'OffersController@patchOffer');
$router->delete('offers', 'OffersController@deleteOffer');








?>