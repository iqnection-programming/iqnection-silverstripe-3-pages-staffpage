<?
class StaffMember extends DataObject
{
	private static $db = array( 
		"SortOrder" => "Int",
		"Name" => "Varchar(255)",
		"Title" => "Varchar(255)",
		"Caption" => "Varchar(255)",
		"Bio" => "HTMLText"
	);
	
	private static $default_sort = "SortOrder ASC";
	
	private static $summary_fields = array(
		"Name" => "Name",
		"Title" => "Title"
	);
	
	private static $has_one = array(
		"Image" => "Image",
		"StaffPage" => "StaffPage"
	);
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->push( new HiddenField('SortOrder',null,$fields->dataFieldByName('SortOrder')->Value()) );
		$fields->dataFieldByName('Name')->setTitle('Staff Member Name');
		$fields->dataFieldByName('Title')->setTitle('Staff Member Title');
		$fields->insertAfter($fields->dataFieldByName('Image'),'Caption');
		$fields->dataFieldByName('Image')->setAllowedFileCategories('image')->setTitle('Staff Member Image')->setDescription('Image will be cropped to 350x400px');
		$fields->dataFieldByName('Caption')->setTitle('Inside Picture Caption');
		$this->extend('updateCMSFields',$fields);
		return $fields;
	}
	
	public function canCreate($member = null) { return true; }
	public function canDelete($member = null) { return true; }
	public function canEdit($member = null) { return true; }
	public function canView($member = null) { return true; }
}

class StaffPage extends Page
{
	private static $db = array(
	);	
	
	private static $has_many = array(
		"StaffMembers" => "StaffMember"
	);	
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.StaffMembers', GridField::create(
			'StaffMembers',
			'Staff Members',
			$this->StaffMembers(),
			GridFieldConfig_RecordEditor::create()->addComponent(
				new GridFieldSortableRows('SortOrder')
			)
		));
		return $fields;
	}		
}

class StaffPage_Controller extends Page_Controller
{	
	private static $allowed_actions = array(
		"member"
	);
	
	public function init()
	{
		parent::init();
	}
	
	public function member()
	{
		if( $member = $this->StaffMembers()->byID($this->request->param('ID')) )
		{
			return $this->Customise(array(
				'Member' => $member
			));
		}
		else
		{
			return $this->httpError(404, "Member not found.");
		}
	}
}

