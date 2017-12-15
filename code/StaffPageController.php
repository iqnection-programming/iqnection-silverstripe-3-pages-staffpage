<?php


class StaffPageController extends PageController
{	
	private static $allowed_actions = [
		"member"
	];
	
	public function member()
	{
		if( $member = $this->StaffMembers()->byID($this->request->param('ID')) )
		{
			return $this->Customise(array(
				'StaffMember' => $member
			));
		}
		return $this->httpError(404, "Member not found.");
	}
}

