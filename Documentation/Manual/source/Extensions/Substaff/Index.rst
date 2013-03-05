Personen- und Gruppendatenbank (substaff)
=========================================

What does it do?
----------------

The TYPO3 Extension *substaff* uses tables, relations and fields from *tt_address* to display people and groups in the frontend.

*Nkwsubfeprojects* is also required for this extension to display the project members and vice versa the relation from person to projects.

This extensions has been rewritten based on the pi_base extension *nkwsubstaff* that becomes obsolete.

Technical Stuff
---------------

The Extension is written using the Extbase Framework and Fluid as templating engine and is tested to work in TYPO3 version >= 4.6

Required third party extensions
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

* fed
* nkwsubfeprojects
* tt_address
* t3jquery

CSS
~~~

CSS files are located in `Resources/Public/Css` and are included at a central location in the default Layout via a *fed* view helper.

These files are generated with Sass or Compass (decide which flavour you like). The source files are located in `Resources/Private/Sass/`.
You may actively build the CSS files with a Sass command or just head to the folder with your preferred shell and hit ``compass watch .``
The compass configuration is provided in the directory. To adjust it, simply edit config.rb.

JavaScript
~~~~~~~~~~

JavaScript is solely used in a very small part - just for persisting your clicks on person's or group's list entries until the next click or reload.

The JavaSript file Substaff.js is located in `Resources/Public/JavaScript/` and included in the default layout with a fed view helper. The JavaScript
itself is generated with CoffeeScript, for details on CoffeeScript see http://coffeescript.org/

The required Extension t3jquery may evaluate the t3jquery.txt file that is provided in this extension.

Installation and configuration
------------------------------

Install this extension and all dependencies and insert the shipped TypoScript.

Make sure that nkwaddressextend is not installed to avoid possible collisions

Todo
----

* Add relation for room numbers to have it normalized - these must be in relation to the buildings table
* Extract vocabulary for group leadings (triple?)