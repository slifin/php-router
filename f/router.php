<?php
namespace f;
class Router{
	function run(\f\routes $routes){
		$route = $this->match($routes);
		if ($route)
			$this->execute(reset($route));
	}
	function match(\f\routes $routes){
		return array_filter($routes->list,[$this,'filter']);
	}
	function filter($routes){
		$path = $this->split($routes['path']);
		$url = $this->split($_SERVER['REQUEST_URI']);
		if (count($path)!=count($url))
			return false;
		$grouped = array_combine($path ,$url);
		return array_reduce($this->flatten($grouped),[$this,'compare']);
	}
	function compare($carry,$val){
		if ($carry) return true;
		return ($val[0]==$val[1] || stripos($val[0],'@')!==FALSE);
	}
	function flatten($array){
		return array_map(function($key) use($array){
			return [$key,$array[$key]];
		},array_keys($array));
	}
	function split($url){
		return explode('/',$url);
	}
	function execute($route){
		$class= new $route['go']['ns'];
		$class->{$route['go']['method']}();
	}
}
class Routes{
	function load($routes){
		$this->list = $routes;
		return $this;
	}
}