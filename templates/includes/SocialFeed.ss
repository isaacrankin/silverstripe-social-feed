<div class="social-feed">
	<ol>
		<% loop SocialFeed %>
			<li>
				<a href="$URL" target="_blank">
					<h4>Type: $Type</h4>
					<p>Created: $Created</p>
					<p>User: $UserName</p>
					<p><img src="$Image" /></p>
					<p>$Content</p>
				</a>
			</li>
		<% end_loop %>
	</ol>
</div>

