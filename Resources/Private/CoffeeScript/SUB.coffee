$.fx.speeds._default = 250

$ ->
  isMobile = mobilecheck()
  if isMobile
    $('.desktop-only').hide()
    $('.mobile-only').show()

  # TODO: What is page-1616?
  if document.getElementById('page-1616') and
  window.location.search.indexOf('tx_solr') is -1
    $('aside.infocontent').hide()

  # Remove border from images with link
  $('a img').parent('a').css('border-bottom', 0)

  initMenus()

  $('.contenttable tr td').each (index) ->
    columns = $(this).closest('.contenttable').find('th').length
    th = $(this).closest('.contenttable').find('th').eq(index % columns)

    $(this).attr('data-label', th.text())

  # Stats for GOK Browsing
  $('.tree li').click = (data) ->
    if typeof piwikTracker isnt 'undefined'
      trackingData = 'GOK' + document.location.pathname + $('.GOKID', this).text()
      piwikTracker.trackPageView(trackingData)

  if location.search.substring(1, 8) is 'tx_solr' and typeof(piwikTracker) isnt 'undefined'
    searchTerm = location.search.split('&')[0].split('=')[1]
    td = 'Searchterm/' + searchTerm
    piwikTracker.trackPageView(td)
    piwikTracker.setCustomVariable( 1, 'Suchbegriff', searchTerm, 'page')

  $('.header_toggle-nav').click ->
    $('.wrap').toggleClass('-show-off-canvas')
    false

  $('.wrap').click ->
    $(this).removeClass('-show-off-canvas')

  headerHeight = $('.header').height()
  paginationOffsets = []
  listBottoms = []
  $('.pagination').each ->
    paginationOffsets.push $(this).offset().top
    $list = $(this).siblings('ol, ul')
    listBottoms.push if $list.length then ($list.offset().top + $list.outerHeight()) - 99 else 0

  $(window).scroll ->
    if $(this).scrollTop() > headerHeight
      $('.colophon_top-link:not(.-visible)').addClass('-visible')
    else
      $('.colophon_top-link.-visible').removeClass('-visible')

    $('.pagination').each (index, e) ->
      scrollTop = $(window).scrollTop()
      if scrollTop > paginationOffsets[index] and scrollTop < listBottoms[index]
        $(this).addClass('-fixed')
      else
        $(this).removeClass('-fixed')

  $('.colophon_top-link').click ->
    $('html, body').animate
      scrollTop: 0
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

  $('a[href$=pdf]').click ->
    window.open($(this).attr('href'))
    false

  # Add sidebar TOC above content to ease navigation on small screens
  $header = $('.content .csc-header:first')
  sidebarLinks = []
  $('.sidebar > .csc-default').each( ->
    $this = $(this)
    id = $this.attr('id')
    unless id then return true
    headingText = $(this).find('h1, h2, h3, h4, h5, h6').first().text()
    link =
      title: headingText
      id: id
    sidebarLinks.push(link)
  )
  if sidebarLinks.length > 0
    $list = $('<ol class="sidebar-nav_list"/>')
    for link in sidebarLinks
      unless link.title then continue
      $item = $('<li class="sidebar-nav_item"/>')
      $link = $("<a class='sidebar-nav_link' href='##{link.id}'>#{link.title}</a>")
      $link.click ->
        $('html, body').animate
          scrollTop: $( $(this).attr('href') ).offset().top
        false
      $item.append($link).appendTo($list)
    if ( $list.children().length > 0 )
      $('<div class="sidebar-nav"/>').append($list).appendTo($header)

  # Toggle-button for Pazpar2 facets on small screens
  if window.pz2Initialised?
    $('.content').on('click', '#pz2-termLists h4', ->
      # Add class to ancestor that does not get re-rendered for every new result
      $('#pazpar2').toggleClass('pz2-show-facets')
    )

initMenus = ->
  $('.nav_list.-secondary').hide()
  $('.nav_list').has('.-current').show()
  $('.nav_link.-current').siblings().show()

  $('.nav_list').each ->
    $('#' + this.id).show()

  $('.nav_link.-toggle').click ->
    $(this)
      .toggleClass('-open')
      .attr('aria-expanded', $(this).attr('aria-expanded') isnt 'true')

    navList = $(this).next('.nav_list')
    $('.nav_link').not(this).removeClass('-open')
    $('.nav_list.-secondary')
      .not(navList)
      .slideUp()
    navList.slideToggle()
    return false

mobilecheck = ->
  check = false
  ((a) ->
    if /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) or /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))
      check = true
    return
  ) navigator.userAgent or navigator.vendor or window.opera
  check
