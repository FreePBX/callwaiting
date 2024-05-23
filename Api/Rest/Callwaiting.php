<?php
namespace FreePBX\modules\Callwaiting\Api\Rest;
use FreePBX\modules\Api\Rest\Base;
class Callwaiting extends Base {
	protected $module = 'callwaiting';
	public function setupRoutes($app) {

		/**
		* @verb GET
		* @return - a list of users' callwaiting settings
		* @uri /callwaiting/users
		*/
		$app->get('/users', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('callwaiting');
			$response->getBody()->write(json_encode(callwaiting_get()));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		 * @verb GET
		 * @returns - a users' callwaiting settings
		 * @uri /callwaiting/users/:id
		 */
		$app->get('/users/{id}', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('callwaiting');
			$response->getBody()->write(json_encode(callwaiting_get($args['id'])));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllReadScopeMiddleware());

		/**
		* @verb PUT
		* @uri /callwaiting/users/:id
		*/
		$app->put('/users/{id}', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('callforward');
			$params = $request->getParsedBody();
			callwaiting_set($args['id'], $params['state']);
			$response->getBody()->write(json_encode(true));
			return $response->withHeader('Content-Type', 'application/json');
		})->add($this->checkAllWriteScopeMiddleware());
	}
}
