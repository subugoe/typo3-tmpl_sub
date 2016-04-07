<?php
namespace Subugoe\TmplSub\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Adds the header information to a page - especially if on a node
 */
class AddJavaScriptViewHelper extends AbstractViewHelper
{

    /**
     * @param string $src
     */
    public function render($src)
    {

        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addJsFooterFile($src);
    }
}
