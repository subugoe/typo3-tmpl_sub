# Readme

insert useful content here - stuff like what this code is all about, dependencies and use cases

# Development tips

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
