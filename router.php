<?php
class router {
	function run(routes $routes) {
		$route = array_values($this->match($routes));
		return (new _)->get($route, '[0][1]', function () {
			return 'not found';
		});
	}
	function match(routes $routes) {
		return array_filter($routes->props,
			(new _)->curry([$this, 'filterPaths'],
				(new _), $this->split($_SERVER['REQUEST_URI'])));
	}
	function filterPaths($path, $current) {
		$path = $this->split(reset($path));
		return (count($path) == count($current)
			&& (new _)->reduce([$this, 'comparePaths'],
				array_combine($path, $current), true));
	}
	function comparePaths($carry, $val, $key) {
		return ($val == $key || stripos($val, '@') !== FALSE) && $carry;
	}
	function split($url) {
		return explode('/', $url);
	}
}
class routes {
	public $props;
	function create($params) {
		$this->props = $params;
		return $this;
	}
}