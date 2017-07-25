<?php

namespace FaimMedia\Websocket;

use Ratchet\App as RatchetApp;

use React\EventLoop\LoopInterface;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\Server as Reactor;
use Ratchet\Http\HttpServerInterface;
use Ratchet\Http\OriginCheck;
use Ratchet\Wamp\WampServerInterface;
use Ratchet\Server\IoServer;
use Ratchet\Server\FlashPolicy;
use Ratchet\Http\HttpServer;
use Ratchet\Http\Router;
use Ratchet\WebSocket\WsServer;
use Ratchet\Wamp\WampServer;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class App extends RatchetApp {

	/**
	 * @param string        $httpHost HTTP hostname clients intend to connect to. MUST match JS `new WebSocket('ws://$httpHost');`
	 * @param int           $port     Port to listen on. If 80, assuming production, Flash on 843 otherwise expecting Flash to be proxied through 8843
	 * @param string        $address  IP address to bind to. Default is localhost/proxy only. '0.0.0.0' for any machine.
	 * @param LoopInterface $loop     Specific React\EventLoop to bind the application to. null will create one for you.
	 */
	public function __construct($httpHost = 'localhost', $port = 8080, $address = '127.0.0.1', LoopInterface $loop = null) {
		if (extension_loaded('xdebug')) {
			trigger_error('XDebug extension detected. Remember to disable this if performance testing or going live!', E_USER_WARNING);
		}
		if (3 !== strlen('✓')) {
			throw new \DomainException('Bad encoding, length of unicode character ✓ should be 3. Ensure charset UTF-8 and check ini val mbstring.func_autoload');
		}
		if (null === $loop) {
			$loop = LoopFactory::create();
		}

		$this->httpHost = $httpHost;
		$this->port = $port;

		$socket = new Reactor($loop);
		$socket->listen($port, $address);
		$this->routes  = new RouteCollection;
		$this->_server = new IoServer(new HttpServer(new Router(new UrlMatcher($this->routes, new RequestContext))), $socket, $loop);
	}
}