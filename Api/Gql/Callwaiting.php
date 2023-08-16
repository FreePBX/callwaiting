<?php

namespace FreePBX\modules\Callwaiting\Api\Gql;

use GraphQL\Type\Definition\Type;
use FreePBX\modules\Api\Gql\Base;

class Callwaiting extends Base {
	protected $module = 'callwaiting';

	public function postInitializeTypes() {
		if($this->checkAllReadScope()) {
			$user = $this->typeContainer->get('coreuser');

			$user->addFieldCallback(fn() => [
					'callwaiting' => [
						'type' => Type::boolean(),
						'description' => 'Turn off/on Call waiting',
						'resolve' => function($user) {
							if(!isset($user['extension'])) {
								return null;
							}
							return $this->freepbx->Callwaiting->getStatusByExtension($user['extension']) === "ENABLED";
						}
					]
				]);
		}
	}
}
