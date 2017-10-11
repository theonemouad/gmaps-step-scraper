<?php

$api = "GOOGLEMAPSAPI";

$from = 'Universitas Sebelas Maret';
$to = 'Pangandaran Beach, West Java';

$maps = @file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($from)."&alternatives=true&destination=".urlencode($to)."&key=$api");

$maps = json_decode($maps, true);
$routes_list = $maps['routes'];
$routes = $routes_list[2]['legs'];
$legs = $routes[0];

$distance = $legs['distance'];
$duration = $legs['duration'];
$start = $legs['start_location'];
$end = $legs['end_location'];

echo $distance['text'] . ":" . $duration['text'];

$n = 0;

foreach($legs['steps'] as $s)
{
  $n++;
  $l = $s['start_location'];
  echo $l['lat'] . ", " . $l['lng'] . "\n";
  if($n == count($legs['steps']))
    echo $s['end_location']['lat'] . ", " . $s['end_location']['lng'];
}

?>
