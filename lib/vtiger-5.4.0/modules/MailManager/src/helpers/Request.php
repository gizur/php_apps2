<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
class MailManager_Request {
	protected $valuemap;
	
	function __construct($values) {
		$this->valuemap = $values;
	}
	
	function has($key) {
		return isset($this->valuemap[$key]);
	}
	
	function get($key, $defvalue='') {
		$value = $defvalue;
		if (isset($this->valuemap[$key])) {
			$value = $this->valuemap[$key];
		}
		if (!empty($value)) {
			$value = vtlib_purify($value);
		}
		return urldecode($value);
	}
	
	function set($key, $value) {
		$this->valuemap[$key] = $value;
	}
	
	function values() {
		return $this->valuemap;
	}
	
	function keys() {
		return array_keys($this->valuemap);
	}
	
	function getOperation($defvalue='') {
		return $this->get('_operation', $defvalue);
	}
	
	function getOperationArg($defvalue='') {
		return $this->get('_operationarg', $defvalue);
	}
}
?>