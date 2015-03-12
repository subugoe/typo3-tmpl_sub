jQuery(document).ready(function () {
	// Bilder mit Links nicht mit Border versehen
	jQuery('a img').parent('a').css('border-bottom', 0);
	initMenus();

	function initMenus() {

		// hides all ULs with class "js"
		jQuery('ul.submenu-l1 ul.js').hide();

		// Show all submenu items where the parent Element has the class submenu-highlight-parent
		jQuery('ul.submenu-l1 .submenu-highlight-parent').next('ul').css('display', 'block');

		jQuery.each(jQuery('ul.submenu-l1'), function () {
			jQuery('#' + this.id + ' ul.go').show();
		});
		jQuery('ul.submenu-l1 li a.submenu-trigger').click(
				function () {
					var checkElement = jQuery(this).next();
					var parent = this.parentNode.parentNode.id;

					if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
						jQuery(this).removeAttr('href');
						jQuery('#' + parent + ' ul.js:visible').slideUp('normal');
						checkElement.slideDown('normal');
						return false;
					}
				}
		);
	}

		// stats for GOK Browsing
	jQuery('.tree li').click(function(data){
		if (typeof(piwikTracker) != 'undefined') {
				var td = 'GOK' + document.location.pathname + jQuery('.GOKID', this).text();
				piwikTracker.trackPageView(td);
			}
	});
	if (location.search.substring(1, 8) == 'tx_solr' && typeof(piwikTracker) != 'undefined') {
		var	searchTerm = location.search.split('&')[0].split('=')[1];
		var td = 'Searchterm/' + searchTerm;
		piwikTracker.trackPageView(td);
		piwikTracker.setCustomVariable( 1, 'Suchbegriff', searchTerm, 'page');
	}
});

/*
 * classList.js: Cross-browser full element.classList implementation.
 * 2011-06-15
 *
 * By Eli Grey, http://eligrey.com
 * Public Domain.
 * NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
 */

/*global self, document, DOMException */

/*! @source http://purl.eligrey.com/github/classList.js/blob/master/classList.js*/

if (typeof document !== "undefined" && !("classList" in document.createElement("a"))) {

	(function (view) {

		"use strict";

		var classListProp = "classList", protoProp = "prototype", elemCtrProto = (view.HTMLElement || view.Element)[protoProp], objCtr = Object, strTrim = String[protoProp].trim || function () {
			return this.replace(/^\s+|\s+$/g, "");
		}, arrIndexOf = Array[protoProp].indexOf || function (item) {
			var i = 0, len = this.length;
			for (; i < len; i++) {
				if (i in this && this[i] === item) {
					return i;
				}
			}
			return -1;
		}, DOMEx = function (type, message) {
			this.name = type;
			this.code = DOMException[type];
			this.message = message;
		}, checkTokenAndGetIndex = function (classList, token) {
			if (token === "") {
				throw new DOMEx(
						"SYNTAX_ERR", "An invalid or illegal string was specified"
				);
			}
			if (/\s/.test(token)) {
				throw new DOMEx(
						"INVALID_CHARACTER_ERR", "String contains an invalid character"
				);
			}
			return arrIndexOf.call(classList, token);
		}, ClassList = function (elem) {
			var trimmedClasses = strTrim.call(elem.className), classes = trimmedClasses ? trimmedClasses.split(/\s+/) : [], i = 0, len = classes.length;
			for (; i < len; i++) {
				this.push(classes[i]);
			}
			this._updateClassName = function () {
				elem.className = this.toString();
			};
		}, classListProto = ClassList[protoProp] = [], classListGetter = function () {
			return new ClassList(this);
		};
// Most DOMException implementations don't allow calling DOMException's toString()
// on non-DOMExceptions. Error's toString() is sufficient here.
		DOMEx[protoProp] = Error[protoProp];
		classListProto.item = function (i) {
			return this[i] || null;
		};
		classListProto.contains = function (token) {
			token += "";
			return checkTokenAndGetIndex(this, token) !== -1;
		};
		classListProto.add = function (token) {
			token += "";
			if (checkTokenAndGetIndex(this, token) === -1) {
				this.push(token);
				this._updateClassName();
			}
		};
		classListProto.remove = function (token) {
			token += "";
			var index = checkTokenAndGetIndex(this, token);
			if (index !== -1) {
				this.splice(index, 1);
				this._updateClassName();
			}
		};
		classListProto.toggle = function (token) {
			token += "";
			if (checkTokenAndGetIndex(this, token) === -1) {
				this.add(token);
			} else {
				this.remove(token);
			}
		};
		classListProto.toString = function () {
			return this.join(" ");
		};

		if (objCtr.defineProperty) {
			var classListPropDesc = {
				get:classListGetter, enumerable:true, configurable:true
			};
			try {
				objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
			} catch (ex) { // IE 8 doesn't support enumerable:true
				if (ex.number === -0x7FF5EC54) {
					classListPropDesc.enumerable = false;
					objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
				}
			}
		} else if (objCtr[protoProp].__defineGetter__) {
			elemCtrProto.__defineGetter__(classListProp, classListGetter);
		}
	}(self));

}