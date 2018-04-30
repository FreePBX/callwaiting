<?php
namespace FreePBX\modules\Callwaiting;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $configs = $this->getConfigs();
    /** Lets pretend we are bulk handler */
    $import = [];
    foreach($configs as $key => $value){
      if(isset($value['callwaiting_enable'])) {
        continue;
      }
      $final[] = ['callwaiting_enable' => $value['callwaiting_enable'], 'extension' => $key]; 
    }
    $this->FreePBX->Callwaiting->bulkhandlerImport('extensions',$final);
  }
}