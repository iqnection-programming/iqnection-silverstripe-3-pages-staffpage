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
		
		private static $default_sort = "SortOrder";
		
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
			$fields = new FieldList();
			$image_field = new UploadField("Image", "Staff Image");
			$image_field->setAllowedFileCategories('image');
			$fields->push( new TextField('Name', 'Staff Name'));
			$fields->push( new TextField('Title', 'Staff Title'));
			$fields->push( $image_field);
			$fields->push( new TextField('Caption', 'Inside Picture Caption'));
			$fields->push( new HTMLEditorField('Bio', 'Staff Bio'));
			$this->extend('updateCMSFields',$fields);
			return $fields;
		}
		
		public function getLandingThumb()
		{
			if( $this->ImageID ) {
				if( $img = $this->Image() ) {
					if( $cropped = $img->CroppedImage(300,350) )
						return $cropped->Filename;
				}
			}
			return "";
		}
		
		public function getInsideThumb()
		{
			if( $this->ImageID ) {
				if( $img = $this->Image() ) {
					if( $cropped = $img->CroppedImage(270,320) )
						return $cropped->Filename;
				}
			}
			return "";
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
			$staff_config = GridFieldConfig::create()->addComponents(				
				new GridFieldSortableRows('SortOrder'),
				new GridFieldToolbarHeader(),
				new GridFieldAddNewButton('toolbar-header-right'),
				new GridFieldSortableHeader(),
				new GridFieldDataColumns(),
				new GridFieldPaginator(10),
				new GridFieldEditButton(),
				new GridFieldDeleteAction(),
				new GridFieldDetailForm()				
			);
			$fields->addFieldToTab('Root.Content.StaffMembers', new GridField('StaffMembers','Staff Members',$this->StaffMembers(),$staff_config));
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
			if( $member = $this->getCurrentMember() )
			{
				$data = array(
					'Member' => $member
				);
				return $this->Customise($data);
			}
			else
			{
				return $this->httpError(404, "Member not found.");
			}
		}
		
		public function getCurrentMember()
		{
			$params = $this->getURLParams();			 
			if( is_numeric($params['ID']) && $member = DataObject::get_by_id('StaffMember', (int)$params['ID']) )
				return $member;
		}
	}
?>