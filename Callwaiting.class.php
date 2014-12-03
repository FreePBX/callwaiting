<?php
// vim: set ai ts=4 sw=4 ft=php:

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
	public function backup(){

	}
	public function restore($backup){

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
		if ($state != "") {
			$ret = $this->FreePBX->astman->database_put('CW',$extension,$state);
		} else {
			$ret = $this->FreePBX->astman->database_del('CW',$extension);
			$ret = $ret['result'];
		}
		return $ret;
	}
}
