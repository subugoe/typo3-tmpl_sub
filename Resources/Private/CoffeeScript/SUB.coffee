$ ->
	$("aside.infocontent").hide()  if document.getElementById('page-1616') and window.location.search.indexOf("tx_solr") is -1

	# Bilder mit Links nicht mit Border versehen
	$('a img').parent('a').css('border-bottom', 0)
	initMenus()

	# stats for GOK Browsing
	$('.tree li').click = (data) ->
		if typeof piwikTracker isnt "undefined"
			trackingData = "GOK" + document.location.pathname + jQuery(".GOKID", this).text()
			piwikTracker.trackPageView(trackingData)

	if location.search.substring(1, 8) is "tx_solr" and typeof(piwikTracker) isnt "undefined"
		searchTerm = location.search.split("&")[0].split("=")[1]
		td = "Searchterm/" + searchTerm
		piwikTracker.trackPageView(td)
		piwikTracker.setCustomVariable( 1, "Suchbegriff", searchTerm, "page")

	# TODO: Search test
	$('.search_input').focus ->
		$('.search').addClass('-show-all')
		$('.search_navigation a:first').addClass('-active') # TODO

	$('.search').click ->
		false

	# Off-canvas nav

	$('.main_left, .header_show-nav').click (e) ->
		e.stopPropagation()

	$('.header_show-nav').click ->
		$('body').toggleClass('-show-off-canvas')
		return false

	$('body').click ->
		$('.search').removeClass('-show-all')
		$('body').removeClass('-show-off-canvas')

initMenus = ->
	$('.nav_list.-secondary').hide()

	# Show all submenu items where the parent Element has the class submenu-highlight-parent
	$('.nav_list').has('.-current').show()
	#$('.submenu-l2-1029, .submenu-l2-1043, .submenu-l2-1051, .submenu-l2-1059, .submenu-l2-1067, .submenu-l2-1033').children('ul').hide() # TODO: WAT? Please explain.

	$('.nav_list').each ->
		$('#' + this.id).show()

	# triggering
	$('.nav_link').click ->
		$nav_list = $(this).next('.nav_list')
		if $nav_list.length
			$('.nav_list .-secondary').not($nav_list).slideUp()
			$nav_list.slideToggle();
			return false
