<h1>$MenuTitle</h1>
$Content
<ul id="staff_members">
    <% loop $StaffMembers %>
        <li>
            <a class="sponsor_link" href="{$Up.AbsoluteLink}member/$ID">
            	<img class="sponsor_static" src="$Image.Fill(350,400).URL" alt="$Name $Title" />
                <div class="sponsor_labels">
                    <p class="sponsor_name">$Name</p>
                    <p class="sponsor_title">$Title</p>
                </div>
            </a>
        </li>
    <% end_loop %>
</ul>