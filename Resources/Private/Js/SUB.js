var initMenus;

$(function() {
  var headerHeight, listBottoms, paginationOffsets, searchTerm, td;
  if (document.getElementById('page-1616') && window.location.search.indexOf("tx_solr") === -1) {
    $("aside.infocontent").hide();
  }
  $('a img').parent('a').css('border-bottom', 0);
  initMenus();
  $('.tree li').click = function(data) {
    var trackingData;
    if (typeof piwikTracker !== "undefined") {
      trackingData = "GOK" + document.location.pathname + $(".GOKID", this).text();
      return piwikTracker.trackPageView(trackingData);
    }
  };
  if (location.search.substring(1, 8) === "tx_solr" && typeof piwikTracker !== "undefined") {
    searchTerm = location.search.split("&")[0].split("=")[1];
    td = "Searchterm/" + searchTerm;
    piwikTracker.trackPageView(td);
    piwikTracker.setCustomVariable(1, "Suchbegriff", searchTerm, "page");
  }
  $('.header_show-nav').click(function() {
    $('body').toggleClass('-show-off-canvas');
    return false;
  });
  $('body').click(function() {
    return $('body').removeClass('-show-off-canvas');
  });
  headerHeight = $('.header').height();
  paginationOffsets = [];
  listBottoms = [];
  $('.pagination').each(function() {
    var $list;
    paginationOffsets.push($(this).offset().top);
    $list = $(this).siblings('ol, ul');
    return listBottoms.push($list.length ? ($list.offset().top + $list.outerHeight()) - 99 : 0);
  });
  $(window).scroll(function() {
    if ($(this).scrollTop() > headerHeight) {
      $('.footer_top-link:not(.-visible)').addClass('-visible');
    } else {
      $('.footer_top-link.-visible').removeClass('-visible');
    }
    return $('.pagination').each(function(index, e) {
      var scrollTop;
      scrollTop = $(window).scrollTop();
      if (scrollTop > paginationOffsets[index] && scrollTop < listBottoms[index]) {
        return $(this).addClass('-fixed');
      } else {
        return $(this).removeClass('-fixed');
      }
    });
  });
  $('.footer_top-link').click(function() {
    $('html, body').animate({
      scrollTop: 0
    });
    return false;
  });
  return $('.pagination.-alphabet a').click(function() {
    var $pagination, id, offset;
    $pagination = $(this).closest('.pagination');
    id = $(this).attr('href').split('#')[1];
    offset = $pagination.outerHeight() * ($pagination.is('.-fixed') ? 1 : 3);
    $('html, body').animate({
      scrollTop: $('#' + id).offset().top - offset
    });
    return false;
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
