<?php
namespace Subugoe\TmplSub\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Adds the header picture with some information
 */
class BigPictureViewHelper extends AbstractViewHelper
{

    const WIKICOMMONSIMG = 'cc_commons.png';
    const CCIMG = 'nur_cc.png';
    const NURINFOIMG = 'nur_info.png';
    const CCLIZENZ = '';

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $local_cObj;

    /**
     * @var int
     */
    protected $page_id;

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
        $content = '';
        $this->local_cObj = $this->frontendController->cObj;

        $this->page_id = $this->frontendController->id;

        $results = $this->getBigPictureFromPage($this->page_id);

        $foundCount = count($results);

        if ($foundCount > 0) {
            // Use the first result
            $content = $this->formatBigPicture($results[0]);
            $content .= $this->getImageInformation($results[0]);
            $content = '<div class="header_image">' . $content . '</div>';
        } elseif ($this->checkRootlineForPics()) {
            // Check rootline to see if we have inherited pics
            $results = $this->getBigPictureFromPage($this->checkRootlineForPics());
            $content = $this->formatBigPicture($results[0]);
            $content .= $this->getImageInformation($results[0]);
            $content = '<div class="header_image">' . $content . '</div>';
        }

        return $content;
    }

    /**
     * Gets picture Information
     *
     * @param $pageId
     * @return array
     */
    protected function getBigPictureFromPage($pageId)
    {

        /** @var \TYPO3\CMS\Core\Resource\FileRepository $fileRepository */
        $fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);

        $fileObjects = $fileRepository->findByRelation('pages', 'media', $pageId);

        $files = [];

        foreach ($fileObjects as $key => $value) {
            $files[$key]['reference'] = $value->getReferenceProperties();
            $files[$key]['original'] = $value->getOriginalFile()->getProperties();
        }

        return $files;
    }

    /**
      * Renders the image and puts Information to the picture
      *
      * @param array $image
      * @return mixed
      */
     protected function formatBigPicture($image)
     {
         $lconf['image.']['params'] = '';
         $lconf['image.']['file.']['treatIdAsReference'] = 1;
         $lconf['image.']['file'] = $image['reference']['uid'];
         $lconf['image.']['altText'] = '';
         $lconf['image.']['file.']['height'] = 228;
         $lconf['image.']['file.']['width'] = 1000;
         $theImgCode = $this->local_cObj->cObjGetSingle('IMAGE', $lconf['image.']);
         $lconf['image.']['altText'] = $image['original']['caption'];
         $theImgCode = $this->local_cObj->cObjGetSingle('IMAGE', $lconf['image.']);
         $image = $this->local_cObj->stdWrap($theImgCode, $this->conf['image.']);
         return $image;
     }

    /**
         * Get license information for the image
         *
         * @param array $image
         * @return string
         */
        protected function getImageInformation($image)
        {
            $imageUrl = '';

            $imageTitleText = [];

            $imageTitleText[] = $image['caption'];
            $imageTitleText[] = 'Urheber: ' . $image['original']['creator'];
            $imageTitleText[] = 'Copyright: ' . $image['original']['copyright'];

            $imageTitleText = implode(PHP_EOL, $imageTitleText);

            $licenseImagePath = 'typo3conf/ext/tmpl_sub/Resources/Public/Img';
            if ($image['original']['wiki_commons'] != '') {
                $imagePath = self::WIKICOMMONSIMG;
                $cssClass = 'wc';
                $imageUrl = $image['original']['copyright_url'];
                $imageTitleText .= PHP_EOL . $image['original']['wiki_commons'];
            } elseif ($image['original']['creative_commons'] == 1 && $image['original']['wiki_commons'] == '') {
                $imagePath = self::CCIMG;
                $cssClass = 'cc';
                $imageUrl = 'http://creativecommons.org/licenses/by-nc-nd/3.0/';
            } else {
                $imagePath = self::NURINFOIMG;
                $cssClass = 'info';
                if ($image['original']['copyright_url']) {
                    $imageUrl = $image['original']['copyright_url'];
                }
            }

            $completeImagePath = $licenseImagePath . '/' . $imagePath;
            $bild = [];
            $bild['file'] = $completeImagePath;

            // Configuration for the image link
            if ($imageUrl != '') {
                $bild['imageLinkWrap'] = 1;
                $bild['imageLinkWrap.']['enable'] = 1;
                $bild['imageLinkWrap.']['typolink.']['parameter'] = $imageUrl;
                $bild['imageLinkWrap.']['typolink.']['extTarget'] = '_blank';
                $bild['imageLinkWrap.']['JSWindow.'] = 0;
            }
            // add title to the image
            $bild['titleText'] = $imageTitleText;

            $bild['altText'] = "";

            $imageInformation = $this->local_cObj->cObjGetSingle('IMAGE', $bild);

            // return with a special css class for that particular image
            return '<div class="header_image-license -' . $cssClass . '">' . $imageInformation . '</div>';
        }


    /**
     * Check if there is any inherited Headerimage and stop at the first one in the rootline
     *
     * @return bool
     */
    protected function checkRootlineForPics()
    {
        $rootline = $this->frontendController->rootLine;
        $return = false;

        foreach ($rootline as $parentPage) {
            if ($parentPage['tx_nkwsubmenu_picture_follow'] == 1 && $parentPage['media']) {
                return $parentPage['uid'];
                break;
            }
        }
        return $return;
    }
}
