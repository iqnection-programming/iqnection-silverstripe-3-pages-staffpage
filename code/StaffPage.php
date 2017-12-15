<?php

use SilverStripe\Forms;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class StaffPage extends Page
{
	private static $icon = "iq-staffpage/images/icons/staffpage-icon.png";
	
	private static $db = [];
	
	private static $has_many = [
		"StaffMembers" => StaffMember::class
	];
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.StaffMembers', Forms\GridField\GridField::create(
			'StaffMembers',
			'Staff Members',
			$this->StaffMembers(),
			Forms\GridField\GridFieldConfig_RecordEditor::create()
				->addComponent(	new GridFieldSortableRows('SortOrder') )
		));
		$this->extend('updateCMSFields',$fields);
		return $fields;
	}		
}


