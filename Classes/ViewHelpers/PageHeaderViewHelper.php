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

        $header = new \stdClass();

        $rootLine = $this->frontendController->tmpl->rootLine;
        for ($a = 10; $a >= 0; $a--) {
            $isNode = $rootLine[$a]['tx_nkwsubmenu_knot'];
            if ($isNode) {
                $header->title = $rootLine[$a]['title'];
                $header->id = $rootLine[$a]['id'];
                break;
            }
        }

        $this->templateVariableContainer->add('header', $header);
    }
}
