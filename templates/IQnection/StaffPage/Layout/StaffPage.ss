<h1>$Title</h1>
$Content
<ul id="staff_members">
    <% loop $StaffMembers %>
        <li>
            <a class="staff_link" href="$Link">
            	<img class="staff_static" src="$Image.FillFrom(350, 400, $CropPosition).URL" alt="$Name $Title" />
                <div class="staff_labels">
                    <p class="staff_name">$Name</p>
                    <% if $Title %><p class="staff_title">$Title</p><% end_if %>
                </div>
            </a>
        </li>
    <% end_loop %>
</ul>