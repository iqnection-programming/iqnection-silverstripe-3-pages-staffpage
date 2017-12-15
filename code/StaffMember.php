<?php

use SilverStripe\ORM;
use SilverStripe\Forms;

class StaffMember extends ORM\DataObject
{
	private static $db = [
		"SortOrder" => "Int",
		"Name" => "Varchar(255)",
		"Title" => "Varchar(255)",
		"Caption" => "Varchar(255)",
		"Bio" => "HTMLText"
	];
	
	private static $has_one = [
		"Image" => SilverStripe\Assets\Image::class,
		"StaffPage" => StaffPage::class
	];
	
	private static $summary_fields = [
		"CMSThumbnail" => "Photo",
		"Name" => "Name",
		"Title" => "Title"
	];
	
	private static $owns = [
		"Image"
	];
	
	private static $default_sort = "SortOrder ASC";
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->push( Forms\HiddenField::create('SortOrder',null,$fields->dataFieldByName('SortOrder')->Value()) );

		$fields->dataFieldByName('Title')->setTitle('Position/Title');
		$fields->insertBefore('Caption', $fields->dataFieldByName('Image'));
		$fields->dataFieldByName('Image')->setAllowedFileCategories('image/supported')
			->setTitle('Photo')
			->setDescription('Image will be cropped to 350x400px')
			->setFolderName('staff-members');
		$fields->dataFieldByName('Caption')->setTitle('Member Page Photo Caption');
		$this->extend('updateCMSFields',$fields);
		return $fields;
	}
	
	public function canCreate($member = null, $context = array()) { return true; }
	public function canDelete($member = null, $context = array()) { return true; }
	public function canEdit($member = null, $context = array()) { return true; }
	public function canView($member = null, $context = array()) { return true; }
	
	public function validate()
	{
		$result = parent::validate();
		if (!$this->Name) { $result->error('Please provide a Name'); }
		if (!$this->Image()->Exists()) { $result->error('Please provide a Photo'); }
		return $result;
	}
	
	public function CMSThumbnail()
	{
		if ($this->Image()->Exists())
		{
			return $this->Image()->CMSThumbnail();
		}
	}
	
	public function Link()
	{
		return $this->StaffPage()->Link('member/'.$this->ID);
	}
	
	public function onAfterWrite()
	{
		parent::onAfterWrite();
		if ( ($this->Image()->Exists()) && (!$this->Image()->isPublished()) )
		{
			$this->Image()->publishSingle();
		}
	}
}






