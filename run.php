<?php

require('GmapsClass.php');

$app = new GMAPS_StepExtractor("GOOGLEMAPS API"); // AIzaSyDgbKVRKo-DsYr--I6wXj3HKMXu53NksTQ

$from = 'Universitas+Sebelas+Maret,+Jalan+Ir.+Sutami,+Jebres,+Surakarta+City,+Central+Java';
$to = 'Ujung+Genteng+Beach,+West+Java';

// example for usage

$app->from($from)->to($to)->route(3)->duration()->fetch();

?>
