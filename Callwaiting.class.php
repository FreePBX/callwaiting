<?php
// vim: set ai ts=4 sw=4 ft=php:
#[\AllowDynamicProperties]
class Callwaiting implements BMO {

	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}

		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;
	}

	public function doConfigPageInit($page) {

	}

	public function install() {

	}
	public function uninstall() {

	}

	public function genConfig() {

	}

	public function getAllStatuses() {
		return $this->FreePBX->astman->database_show('CW');
	}

	public function getStatusByExtension($extension) {
		return $this->FreePBX->astman->database_get('CW', $extension);
	}

	public function setStatusByExtension($extension, $state = '') {
		$state = trim((string) $state);
		if (!empty($state)) {
			$ret = $this->FreePBX->astman->database_put('CW',$extension,$state);
		} else {
			$ret = $this->FreePBX->astman->database_del('CW',$extension);
		}
		return $ret;
	}
	/* UCP template to get the user assigned vm extension details
	* @defaultexten is the default_extensionof the userman userid
	* @userid is userman user id
	* @widget is an array we need to replace few item based on the userid
	*/
	public function getWidgetListByModule($defaultexten, $userid,$widget) {
		// if the widget_type_id is not defaultextension and widget_type_id is not in extensions
		// then return only the defaultexten details
		$widgets = [];
		$widget_type_id = $widget['widget_type_id'];// this will be an extension number
		$extensions = $this->FreePBX->Ucp->getCombinedSettingByID($userid,'Settings','assigned');
		$extensions = is_array($extensions)?$extensions:[];
		if(in_array($widget_type_id,$extensions)){
			// nothing to do return the same widget
			return $widget;
		}else {// sent the default extension
			$data = $this->FreePBX->Core->getDevice($defaultexten);
			if(empty($data) || empty($data['description'])) {
				$data = $this->FreePBX->Core->getUser($defaultexten);
				$name = $data['name'];
			} else {
				$name = $data['description'];
			}
			$widget['widget_type_id'] = $defaultexten;
			$widget['name'] = $name;
			return $widget;
		}
		return false;
	}

	public function bulkhandlerGetHeaders($type) {
		switch ($type) {
			case 'extensions':
				$headers = ['callwaiting_enable' => ['identifier' => _('Call Waiting Enabled'), 'description' => _('Call Waiting Enabled: ENABLED to enable, blank to disable')]];
				return $headers;
			break;
		}
	}
	public function bulkhandlerExport($type) {
		$data = NULL;
		switch ($type) {
			case 'extensions':
			$data = [];
			$extens = $this->getAllStatuses();
			foreach ($extens as $key => $value) {
				$ext = substr((string) $key,4);
				if($value === 'ENABLED'){
					$data[$ext] = ['callwaiting_enable' => $value];
				}else{
					$data[$ext] = ['callwaiting_enable' => ''];
				}
			}
			break;
		}
		return $data;
	}
	public function bulkhandlerImport($type,$rawData, $replaceExisting = true){
		switch ($type) {
			case 'extensions':
				foreach ($rawData as $data) {
					if(isset($data['callwaiting_enable'])) {
						$curVal = trim((string) $data['callwaiting_enable']);
						if($curVal === 'ENABLED'){
							$this->setStatusByExtension($data['extension'], $curVal);
						}else{
							$this->setStatusByExtension($data['extension']);
						}
					}
				}
			break;
		}
	}
}
