<% with StaffMember %>
    <div id="staff_left">
        <img src="$Image.Fill(350,400).URL" alt="$Name $Title" />
        <% if $Caption %><p>$Caption</p><% end_if %>
    </div><!--staff_left-->
    <div id="staff_right">
        <h1>$Name</h1>
        $Bio
        <a href="$StaffPage.Link">&larr; Back to $StaffPage.Title</a>
    </div><!--staff_right-->
<% end_with %>