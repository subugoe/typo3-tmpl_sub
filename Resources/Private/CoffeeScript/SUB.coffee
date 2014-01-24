$ ->
	# Bilder mit Links nicht mit Border versehen
	$('a img').parent('a').css('border-bottom', 0)
	initMenus()

	# stats for GOK Browsing
	$('.tree li').click = (data) ->
		if typeof piwikTracker isnt "undefined"
			trackingData = "GOK" + document.location.pathname + $(".GOKID", this).text()
			piwikTracker.trackPageView(trackingData)

	if location.search.substring(1, 8) is "tx_solr" and typeof(piwikTracker) isnt "undefined"
		searchTerm = location.search.split("&")[0].split("=")[1]
		td = "Searchterm/" + searchTerm
		piwikTracker.trackPageView(td)
		piwikTracker.setCustomVariable( 1, "Suchbegriff", searchTerm, "page")

initMenus = ->
	# hides all ULs with class "js"
	$('ul.submenu-l1 ul.js').hide()

	# Show all submenu items where the parent Element has the class submenu-highlight-parent
	$('ul.submenu-l1 .submenu-highlight-parent').next('ul').css('display', 'block')
	$('ul.submenu-l1 li.submenu-selected').children('ul').show()
	$('.submenu-l2-1029, .submenu-l2-1043, .submenu-l2-1051, .submenu-l2-1059, .submenu-l2-1067, .submenu-l2-1033').children('ul').hide()


	$('ul.submenu-l1').each ->
		$('#' + this.id + ' ul.go').show()

	# triggering
	$('ul.submenu-l1 li a.submenu-trigger').click ->
		checkElement = $(this).next()
		parent = this.parentNode.parentNode.id;

		if checkElement.is('ul') and  (!checkElement.is(':visible'))
			$(this).removeAttr('href');
			$('#' + parent + ' ul.js:visible').slideUp('normal');
			checkElement.slideDown('normal');
			return false

$("aside.infocontent").hide()  if $("#page-1616") and window.location.search.indexOf("tx_solr") is -1
