<?php
namespace Subugoe\TmplSub\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Adds the header information to a page - especially if on a node
 */
class PageHeaderViewHelper extends AbstractViewHelper
{

    /**
     * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected $frontendController;

    public function initialize()
    {
        parent::initialize();
        $this->frontendController = $GLOBALS['TSFE'];
    }

    public function render()
    {
        $header = [];
        $header['id'] = 1;

        $rootLine = array_reverse($this->frontendController->tmpl->rootLine);

        foreach ($rootLine as $rootLineElement) {
            $isNode = intval($rootLineElement['tx_nkwsubmenu_knot']);
            if ($isNode === 1) {
                $header['title'] = $rootLineElement['title'];
                $header['id'] = $rootLineElement['uid'];
                break;
            }
        }

        $this->templateVariableContainer->add('header', $header);
    }
}
