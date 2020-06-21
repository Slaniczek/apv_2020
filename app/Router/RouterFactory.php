<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('<presenter>/<action>', 'Homepage:default');
        $router->addRoute('/users/detail/id', 'Users:detail');
        $router->addRoute('/locations/detail/id', 'Locations:detail');
        $router->addRoute('/contacts/detail/id', 'Contacts:detail');
        $router->addRoute('/contactTypes/detail/id', 'ContactTypes:detail');
		return $router;
	}
}
