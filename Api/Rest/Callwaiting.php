<?php
namespace FreePBX\modules\Callforward\Api\Rest;
use FreePBX\modules\Api\Rest\Base;
class Callwaiting extends Base {
	public function setupRoutes($app) {
		$app->get('/users', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('callwaiting');
			return $response->withJson(callwaiting_get());
		})->add($this->checkAllReadScopeMiddleware());

		$app->get('/users/{id}', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('callwaiting');
			return $response->withJson(callwaiting_get($args['id']));
		})->add($this->checkAllReadScopeMiddleware());

		$app->put('/users/{id}', function ($request, $response, $args) {
			\FreePBX::Modules()->loadFunctionsInc('callforward');
			$params = $request->getParsedBody();
			callwaiting_set($args['id'], $params['state']);
			return $response->withJson(true);
		})->add($this->checkAllWriteScopeMiddleware());
	}
}
