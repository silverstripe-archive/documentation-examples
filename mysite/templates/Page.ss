<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<% base_tag %>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>$Title - $SiteConfig.Title</title>
		
		$MetaTags
		<meta name="viewport" content="width=device-width">
	</head>
	
	<body>
		$Layout

		<% loop WellingtonWeather %>
			$Description
		<% end_loop %>

		<% with $CurrentMember %>
			<p>Welcome $FirstName $Surname.</p>
		<% end_with %>

		<% if $Dishes %>
		<ul>
			<% loop $Dishes %>
				<li>$Title ($Price.Nice)</li>
			<% end_loop %>
		</ul>
		<% end_if %>

		<p>You are coming from $UsersIpAddress on $TodaysDate.Nice</p>

		<%t Member.WELCOME 'Welcome {name} to {site}' name=$Member.Name site="Foobar.com" %>

		<h2>Pagination</h2>
		<ul>
		<% loop $PaginatedPages %>
			<li><a href="$Link">$Title</a></li>
		<% end_loop %>
		</ul>

		<% if $PaginatedPages.MoreThanOnePage %>
		<% if $PaginatedPages.NotFirstPage %>
			<a class="prev" href="$PaginatedPages.PrevLink">Prev</a>
		<% end_if %>
		<% loop $PaginatedPages.Pages %>
			<% if $CurrentBool %>
				$PageNum
			<% else %>
				<% if $Link %>
					<a href="$Link">$PageNum</a>
				<% else %>
					...
				<% end_if %>
			<% end_if %>
			<% end_loop %>
		<% if $PaginatedPages.NotLastPage %>
			<a class="next" href="$PaginatedPages.NextLink">Next</a>
		<% end_if %>
	<% end_if %>

	$HelloForm
	$SearchForm
	</body>
</html>