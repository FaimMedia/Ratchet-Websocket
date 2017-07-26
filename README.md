# Ratchet-Websocket

Modified wrapper for Ratchet's Websocket `App` class. This wrapper does not use the Flash Socket Server so it could be implemented multiple times on the same server, without the `could not bind to address 0.0.0.0:8843` error message.

Please note that older browsers than IE10 will not be supported with this method.  
[http://caniuse.com/#search=websocket](http://caniuse.com/#search=websocket)

## Install

In order to install this library via `composer` run the following command in the console:

	composer require faimmedia/ratchet-websocket

or add the package manually to your `composer.json` file in the require section:

    "faimmedia/ratchet-websocket": "^1.0"

## Example

There is an example CLI script in the `examples` folder (`Run.php`). Use the `--help` argument for accepted parameters.