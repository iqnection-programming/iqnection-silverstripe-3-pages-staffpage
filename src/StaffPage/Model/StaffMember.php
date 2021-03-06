<?php

namespace IQnection\StaffPage\Model;

use SilverStripe\ORM;
use SilverStripe\Forms;

class StaffMember extends ORM\DataObject
{
	private static $table_name = 'StaffMember';
	
	private static $db = [
		"SortOrder" => "Int",
		"Name" => "Varchar(255)",
		"Title" => "Varchar(255)",
		"Caption" => "Varchar(255)",
		"Bio" => "HTMLText",
		'CropPosition' => "Enum('Top Left,Top Center, Top Right, Left Middle, Center, Right Middle, Bottom Left, Bottom Center, Bottom Right','Center')"
	];
	
	private static $has_one = [
		"Image" => \SilverStripe\Assets\Image::class,
		"StaffPage" => \IQnection\StaffPage\StaffPage::class
	];
	
	private static $summary_fields = [
		"CMSThumbnail" => "Photo",
		"Name" => "Name",
		"Title" => "Title"
	];
	
	private static $owns = [
		"Image"
	];
	
	private static $defaults = [
		'CropPosition' => 'Center'
	];
	
	private static $default_sort = "SortOrder ASC";
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName([
			'LinkTracking',
			'FileTracking'
		]);
		$fields->push( Forms\HiddenField::create('SortOrder',null,$fields->dataFieldByName('SortOrder')->Value()) );

		$fields->dataFieldByName('Title')->setTitle('Position/Title');
		$fields->insertBefore('Caption', $fields->dataFieldByName('Image'));
		$fields->dataFieldByName('Image')->setAllowedFileCategories('image/supported')
			->setTitle('Photo')
			->setDescription('Image will be cropped to 350x400px')
			->setFolderName('staff-members');
		$fields->insertAfter('Image', $fields->dataFieldByName('CropPosition') );
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
		if (!$this->Name) { $result->addError('Please provide a Name'); }
		if (!$this->Image()->Exists()) { $result->addError('Please provide a Photo'); }
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






