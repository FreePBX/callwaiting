<?php
namespace FreePBX\modules\Callwaiting;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
	public function runBackup($id,$transaction){
		$this->addConfigs([
			'data' => $this->FreePBX->Callwaiting->bulkhandlerExport('extensions'),
			'features' => $this->dumpFeatureCodes()
		]);
	}
}