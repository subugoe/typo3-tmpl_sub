var initMenus;

$(function() {
  var searchTerm, td;
  if (document.getElementById('page-1616') && window.location.search.indexOf("tx_solr") === -1) {
    $("aside.infocontent").hide();
  }
  $('a img').parent('a').css('border-bottom', 0);
  initMenus();
  $('.tree li').click = function(data) {
    var trackingData;
    if (typeof piwikTracker !== "undefined") {
      trackingData = "GOK" + document.location.pathname + jQuery(".GOKID", this).text();
      return piwikTracker.trackPageView(trackingData);
    }
  };
  if (location.search.substring(1, 8) === "tx_solr" && typeof piwikTracker !== "undefined") {
    searchTerm = location.search.split("&")[0].split("=")[1];
    td = "Searchterm/" + searchTerm;
    piwikTracker.trackPageView(td);
    piwikTracker.setCustomVariable(1, "Suchbegriff", searchTerm, "page");
  }
  $('.search_input').focus(function() {
    $('.search').addClass('-show-all');
    return $('.search_navigation a:first').addClass('-active');
  });
  $('.search').click(function() {
    return false;
  });
  $('.main_left, .header_show-nav').click(function(e) {
    return e.stopPropagation();
  });
  $('.header_show-nav').click(function() {
    $('body').toggleClass('-show-off-canvas');
    return false;
  });
  return $('body').click(function() {
    $('.search').removeClass('-show-all');
    return $('body').removeClass('-show-off-canvas');
  });
});

initMenus = function() {
  $('.nav_list.-secondary').hide();
  $('.nav_list').has('.-current').show();
  $('.nav_list').each(function() {
    return $('#' + this.id).show();
  });
  return $('.nav_link').click(function() {
    var $nav_list;
    $nav_list = $(this).next('.nav_list');
    if ($nav_list.length) {
      $('.nav_list .-secondary').not($nav_list).slideUp();
      $nav_list.slideToggle();
      return false;
    }
  });
};
