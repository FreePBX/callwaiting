<?php
namespace FreePBX\modules\Callwaiting;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $configs = $this->getConfigs();
    /** Lets pretend we are bulk handler */
    $final = [];
    foreach($configs as $key => $value){
      if(isset($value['callwaiting_enable'])) {
        continue;
      }
      $final[] = ['callwaiting_enable' => $value['callwaiting_enable'], 'extension' => $key]; 
    }
    $this->FreePBX->Callwaiting->bulkhandlerImport('extensions',$final);
  }
  public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir){
    $cw = $this->FreePBX->Callwaiting;
    $astdb = $this->getAstDb($tmpfiledir . '/astdb');
    if (isset($astdb['CW'])) {
      foreach ($astdb['CW'] as $exten => $val) {
        $cw->setStatusByExtension($exten, $val);
      }
    }
  }
}