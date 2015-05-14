<% with Member %>
    <div id="staff_left">
        <img src="$getInsideThumb" alt="$Name $Title" />
        <% if Caption %><p>$Caption</p><% end_if %>
    </div><!--staff_left-->
    <div id="staff_right">
        <h1>$Name</h1>
        $Bio
        <a href="$Up.AbsoluteLink">&larr; Back to Staff</a>
    </div><!--staff_right-->
<% end_with %>