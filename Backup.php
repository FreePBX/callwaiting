<?php
namespace FreePBX\modules\Callwaiting;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
  public function runBackup($id,$transaction){
    $configs = $this->FreePBX->Callwaiting->bulkhandlerExport('extensions');
    $this->addConfigs($configs);
  }
}