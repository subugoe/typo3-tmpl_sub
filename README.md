# quick and dirty development tips

(Nils Windisch 2014-01-09)

* checkout repo from Github
* switch to dev branch
* do stuff [1]
* commit (to dev) and wait 5 minutes
* check results at [WWW03](http://www03.sub.uni-goettingen.de)
* merge branches dev to master / or cherry pick [2]
* commit (to master) and wait 5 minutes
* check results at [WWW](http://www03.sub.uni-goettingen.de)

[1] CSS stuff
* images are to be placed in /Resources/Public/Img/
* there get referenced in /Resources/Private/Sass/Sections/_base.scss - watch for the images sections
** e.g. clearGif: '/typo3conf/ext/tmpl_sub/Resources/Public/Img/clear.gif';
* use them like this: background-image: url($clearGif);
* don't forget to run 'compass compile' otherwise the css files won't get updated

[2] cherry pick stuff
* checkout master branch - changes to dev branch have to be pushed to github already!
* make sure you're up to date with 'git pull'
* cherry pick with 'git cherry-pick a92c64ef449535386a6945e715e963b5fed5737a' - the funny string is the commit ID - search for them e. g. here https://github.com/subugoe/typo3-tmpl_sub/commits/dev
* after cherry picking one or more specific commits from the dev branch close your work with a 'git push'
