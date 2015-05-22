$ ->
	$("aside.infocontent").hide()  if document.getElementById('page-1616') and window.location.search.indexOf("tx_solr") is -1

	# Remove border from images with link
	$('a img').parent('a').css('border-bottom', 0)
	initMenus()

	# Stats for GOK Browsing
	$('.tree li').click = (data) ->
		if typeof piwikTracker isnt "undefined"
			trackingData = "GOK" + document.location.pathname + $(".GOKID", this).text()
			piwikTracker.trackPageView(trackingData)

	if location.search.substring(1, 8) is "tx_solr" and typeof(piwikTracker) isnt "undefined"
		searchTerm = location.search.split("&")[0].split("=")[1]
		td = "Searchterm/" + searchTerm
		piwikTracker.trackPageView(td)
		piwikTracker.setCustomVariable( 1, "Suchbegriff", searchTerm, "page")

	$('.header_show-nav').click ->
		$('body').toggleClass('-show-off-canvas')
		false

	$('body').click ->
		$('body').removeClass('-show-off-canvas')

	# To-top link
	headerHeight = $('.header').height()
	if $('.pagination').length
		paginationOffset = $('.pagination').offset().top
	$(window).scroll ->
		if $(this).scrollTop() > headerHeight
			$('.footer_top-link:not(.-visible)').addClass('-visible')
		else
			$('.footer_top-link.-visible').removeClass('-visible')

		if paginationOffset
			if $(this).scrollTop() > paginationOffset
				$('.pagination:not(.-fixed)').addClass('-fixed')
			else
				$('.pagination.-fixed').removeClass('-fixed')

	$('.footer_top-link').click ->
		$('html, body').animate
			scrollTop:0
		false

	# Alphabet pagination
	$('.pagination.-alphabet a').click ->
		id = $(this).attr('href').split('#')[1]
		console.log id
		$('html, body').animate
			scrollTop: $('#' + id).offset().top - $('.pagination').height()
		false


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
