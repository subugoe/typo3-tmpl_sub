<?php
namespace Subugoe\TmplSub\Hooks;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Ingo Pfennigstorf <pfennigstorf@sub-goettingen.de>
 *      Goettingen State Library
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Manipulates the content if desired
 */
class ContentHook
{
    public function main(&$params, &$obj)
    {
        $this->replace($params);
    }
    public function noCache(&$params, &$obj)
    {
        if (!$GLOBALS['TSFE']->isINTincScript()) {
            return;
        }
        $this->replace($params);
    }
    public function cache(&$params, &$obj)
    {
        if ($GLOBALS['TSFE']->isINTincScript()) {
            return;
        }
        $this->replace($params);
    }

    protected function replace(&$params)
    {
        return $params['pObj']->content = str_replace('<article id="c105" class="csc-default"></article>', '', $params['pObj']->content);
    }
}
