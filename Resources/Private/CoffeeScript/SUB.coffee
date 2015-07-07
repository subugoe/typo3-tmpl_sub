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

	$('.header_toggle-nav').click ->
		$('body').toggleClass('-show-off-canvas')
		false

	$('body').click ->
		$('body').removeClass('-show-off-canvas')

	headerHeight = $('.header').height()
	paginationOffsets = []
	listBottoms = []
	$('.pagination').each ->
		paginationOffsets.push $(this).offset().top
		$list = $(this).siblings('ol, ul')
		listBottoms.push if $list.length then ($list.offset().top + $list.outerHeight()) - 99 else 0

	# To-top link
	$(window).scroll ->
		if $(this).scrollTop() > headerHeight
			$('.footer_top-link:not(.-visible)').addClass('-visible')
		else
			$('.footer_top-link.-visible').removeClass('-visible')

		$('.pagination').each (index, e)->
			scrollTop = $(window).scrollTop()
			if scrollTop > paginationOffsets[index] and scrollTop < listBottoms[index]
				$(this).addClass('-fixed')
			else
				$(this).removeClass('-fixed')

	$('.footer_top-link').click ->
		$('html, body').animate
			scrollTop:0
		false

	# Alphabet pagination
	$('.pagination.-alphabet a').click ->
		$pagination = $(this).closest('.pagination')
		id = $(this).attr('href').split('#')[1]
		# Pagination is not fixed yet, but it will be after scroll,
		# so take its height into account
		offset = $pagination.outerHeight() * ( if $pagination.is('.-fixed') then 1 else 3 )
		$('html, body').animate
			scrollTop: $('#' + id).offset().top - offset
		false


initMenus = ->
	$('.nav_list.-secondary').hide()
	$('.nav_list').has('.-current').show()
	$('.nav_link.-current').siblings().show()

	$('.nav_list').each ->
		$('#' + this.id).show()

	$('.nav_link.-toggle').click ->
		$(this).toggleClass('-open')
		$nav_list = $(this).next('.nav_list')
		if $nav_list.length
			$('.nav_list.-secondary').not($nav_list).slideUp()
			$nav_list.slideToggle();
			return false
