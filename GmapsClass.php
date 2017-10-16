<?php

class GMAPS_StepExtractor {
	
	private $api;
	public $to, $from;
	private $route = 1, $distance = false, $duration = false, $max = 200, $information = false;
	
	function __construct($api) {
		$this->api = $api;
	}
	public function from($x) {
		$this->from = $this->escape($x);
		return $this;
	}
	public function to($x) {
		$this->to = $this->escape($x);
		return $this;
	}
	public function route($route) { $this->route = $route; return $this; }
	public function distance($r = true) { $this->distance = $r; return $this; }
	public function duration($r = true) { $this->duration = $r; return $this; }
	public function max($a) { $this->max = $a; return $this; }
	
	public function fetch() {
		$url = "https://maps.googleapis.com/maps/api/directions/json?origin=".urlencode($this->from)."&alternatives=true&destination=".urlencode($this->to)."&key=" . $this->api;
		$maps = @file_get_contents($url);
		if(empty($maps)) {
			die("Failed to connect to google...");
		} else {
			$maps = json_decode($maps, true);
			
			$routes_list = $maps['routes'];
			if(empty($routes_list[$this->route - 1])) {
				die("Sorry, route not found");
			}
			
			$routes = $routes_list[$this->route - 1]['legs'];
			$legs = $routes[0];
			
			$n = 0;
			foreach($legs['steps'] as $s)
			{
			  $n++;
			  $l = $s['start_location'];
			  
			  $ret = $l['lat'] . ", " . $l['lng'];
			  $fe = '';
			  
			  if($this->distance) {
			  	$fe .= ', ' . trim(str_replace(" km", "", $s['distance']['text']));
			  }
			  
			  if($this->duration) {
			  	$fe .= ', ' . trim(str_replace(["mins", "min"], "", $s['duration']['text']));
			  }
			  
			  $ret .= $fe . "\n";
			  
			  if($n == count($legs['steps'])) {
			  	$ret .= $s['end_location']['lat'] . ", " . $s['end_location']['lng'] . "\n";
			  }
			    
				if($n >= $this->max){
					die();
				}
				echo $ret;
			}
		}
	}
	
	private function escape($string) {
		return str_replace(" ", "+", $string);
	}
}
