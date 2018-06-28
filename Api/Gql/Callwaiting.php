<?php

namespace FreePBX\modules\Callwaiting\Api\Gql;

use GraphQL\Type\Definition\Type;
use FreePBX\modules\Api\Gql\Base;

class Callwaiting extends Base {
	protected $module = 'callwaiting';

	public function mutationCallback() {
		if($this->checkAllWriteScope()) {
		}
	}

	public function queryCallback() {
		if($this->checkAllReadScope()) {
		}
	}

	public function postInitializeTypes() {
	}
	/*
	public function postInitTypes() {
		if($this->checkAllReadScope()) {
			$user = $this->typeContainer->get('user');
			$user->addField('callwaiting', [
				'type' => Type::boolean(),
				'description' => 'Turn off/on Call waiting',
				'resolve' => function($user) {
					return $this->freepbx->Callwaiting->getStatusByExtension($user['extension']) === "ENABLED";
				}
			]);
		}
	}
	*/
}
