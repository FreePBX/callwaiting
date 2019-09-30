<?php
namespace FreePBX\modules\Callwaiting;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
	public function runRestore(){
		$configs = $this->getConfigs();
		/** Lets pretend we are bulk handler */
		$final = [];
		foreach($configs['data'] as $key => $value){
			if(!isset($value['callwaiting_enable'])) {
				continue;
			}
			$final[] = ['callwaiting_enable' => $value['callwaiting_enable'], 'extension' => $key];
		}
		$this->FreePBX->Callwaiting->bulkhandlerImport('extensions',$final);

		$this->importFeatureCodes($configs['features']);
	}
	public function processLegacy($pdo, $data, $tables, $unknownTables){
		$cw = $this->FreePBX->Callwaiting;
		$astdb = $data['astdb'];
		if (isset($astdb['CW'])) {
			foreach ($astdb['CW'] as $exten => $val) {
				$cw->setStatusByExtension($exten, $val);
			}
		}
		$this->restoreLegacyFeatureCodes($pdo);
	}
}
