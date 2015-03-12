(function() {
  var initMenus;

  (function($) {
    var searchTerm, td;
    if (document.getElementById('page-1616') && window.location.search.indexOf("tx_solr") === -1) {
      jQuery("aside.infocontent").hide();
    }
    jQuery('a img').parent('a').css('border-bottom', 0);
    initMenus();
    jQuery('.tree li').click = function(data) {
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
      return piwikTracker.setCustomVariable(1, "Suchbegriff", searchTerm, "page");
    }
  }, initMenus = function() {
    jQuery('ul.submenu-l1 ul.js').hide();
    jQuery('ul.submenu-l1 .submenu-highlight-parent').next('ul').css('display', 'block');
    jQuery('ul.submenu-l1 li.submenu-selected').children('ul').show();
    jQuery('.submenu-l2-1029, .submenu-l2-1043, .submenu-l2-1051, .submenu-l2-1059, .submenu-l2-1067, .submenu-l2-1033').children('ul').hide();
    jQuery('ul.submenu-l1').each(function() {
      return jQuery('#' + this.id + ' ul.go').show();
    });
    return jQuery('ul.submenu-l1 li a.submenu-trigger').click(function() {
      var checkElement, parent;
      checkElement = jQuery(this).next();
      parent = this.parentNode.parentNode.id;
      if (checkElement.is('ul') && (!checkElement.is(':visible'))) {
        jQuery(this).removeAttr('href');
        jQuery('#' + parent + ' ul.js:visible').slideUp('normal');
        checkElement.slideDown('normal');
        return false;
      }
    });
  })(jQuery);

}).call(this);
