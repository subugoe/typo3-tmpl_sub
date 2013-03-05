<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ingo Pfennigstorf <pfennigstorf@sub.uni-goettingen.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Explodes a commaseparated List and returns an array
 * $Id$
 * @author Ingo Pfennigstorf
 */
class Tx_TmplSub_ViewHelpers_CommaExploderViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Returns an array out of a commaseparated list of integers
	 *
	 * @param string $commaList Commaseparated list of integeraluel
	 * @return array
	 */
	public function render($commaList) {

		$intVals = Array();
		if (strpos($commaList, ',')) {
			$intVals = explode(',', $commaList);

				// only values larger than zero will be included
			$intVals = array_filter($intVals, function ($matches) {
				if (intval($matches) > 0) {
					return TRUE;
				}
			});
				// remove spaces
			array_walk($intVals, function($val, $key) use(&$intVals){
				$intVals[$key] = trim($val);
			});

		} elseif ((int) $commaList > 0){
			array_push($intVals, $commaList);
		}
		if (count($intVals) > 0) {
			$return = $intVals;
		} else {
			$return = NULL;
		}
		return $return;
	}

}

?>