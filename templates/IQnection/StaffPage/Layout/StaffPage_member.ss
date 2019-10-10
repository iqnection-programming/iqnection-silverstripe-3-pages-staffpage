<% with StaffMember %>
	<div class="staff-member-layout">
		<div class="staff-left">
			<img src="$Image.Fit(350,400).URL" alt="$Name $Title" />
			<% if $Caption %><p>$Caption</p><% end_if %>
		</div><!--staff_left-->
		<div class="staff-right">
			<h1>$Name</h1>
			$Bio
			<a href="$StaffPage.Link">&larr; Back to $StaffPage.Title</a>
		</div><!--staff_right-->
	</div>
<% end_with %>