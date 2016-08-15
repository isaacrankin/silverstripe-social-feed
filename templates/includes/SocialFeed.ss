<div class="social-feed">
	<ol>
		<% loop SocialFeed %>
			<li>
				<% if $URL %>
				<a href="$URL" target="_blank">
				<% end_if %>
					<h4>Type: $Type</h4>
					<p>Created: $Created.Nice</p>

					<%-- Facebook Post --%>
					<% if $Type == 'facebook' %>
						<p>$Data.message</p>
						<% if $Data.picture %>
							<p><img src="$Data.picture" alt=""></p>
						<% end_if %>

					<%-- Twitter Post --%>
					<% else_if $Type == 'twitter' %>
						<p>URL: $URL</p>
						<p>$Data.text</p>

					<%-- Instagram Post --%>
					<% else_if $Type == 'instagram' %>
						<p><img src="$Data.images.thumbnail.url" alt="" width="$Data.images.thumbnail.width" height="$Data.images.thumbnail.height"></p>
					<% end_if %>
				<% if $URL %>
				</a>
				<% end_if %>
			</li>
		<% end_loop %>
	</ol>
</div>

