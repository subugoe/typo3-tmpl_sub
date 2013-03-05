<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Ingo Pfennigstorf <pfennigstorf@sub.uni-goettingen.de>
 *
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
 ***************************************************************/

/**
 * Test case for class Tx_TmplSub_ViewHelpers_CommaExploderViewHelper
 *
 * @author Ingo Pfennigstorf <pfennigstorf@sub.uni-goettingen.de>
 * @package subtabs
 */
class Tx_TmplSub_Tests_Unit_ViewHelpers_CommaExploderViewHelperTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Subtabs_ViewHelpers_CommaExploderViewHelper
	 */
	protected $fixture;

	/**
	 * @return void
	 */
	public function setUp() {
		$this->fixture = $this->getMock('Tx_TmplSub_ViewHelpers_CommaExploderViewHelper', array('renderChildren'));
	}

	/**
	 * @test
	 */
	public function checkIfArrayIsReturnedTest(){
		$commaList = '4,124,123,1,2';
		$result = $this->fixture->render($commaList);
		$this->assertInternalType('array', $result);
	}

	/**
	 * @test
	 */
	public function checkIfArrayIsReturnedIfOnlyOneValueInListTest() {
		$commaList = '6';
		$result = $this->fixture->render($commaList);
		$this->assertInternalType('array', $result);
	}

	/**
	 * @test
	 */
	public function checkIfNullIsReturnedWithNoValueInListTest() {
		$commaList = '';
		$result = $this->fixture->render($commaList);
		$this->assertNull($result);
	}

	/**
	 * @test
	 */
	public function checkIfValuesBelowZeroAreStrippedTest() {
		$commaList = '4,-124,123,-1,2';
		$result = $this->fixture->render($commaList);
		$this->assertCount(3, $result);
	}

	/**
	 * @test
	 */
	public function checkIfTheArrayLengthEqualsTheElementsInTheCommalistTest() {
		$commaList = '4,124,123,1,2';
		$result = $this->fixture->render($commaList);
		$this->assertCount(5, $result);
	}

	/**
	 * @test
	 */
	public function checkIfNullIsReturnedIfOnlyNegativeValuesAreInTheCommalistTest() {
		$commaList = '-1,-13636,-654';
		$result = $this->fixture->render($commaList);
		$this->assertNull($result);
	}

	/**
	 * @test
	 */
	public function checkIfNullIsReturnedWhenOnlyCommasAreInTheCommalistTest() {
		$commaList = ',,';
		$result = $this->fixture->render($commaList);
		$this->assertNull($result);
	}

	/**
	 * @test
	 */
	public function checkIfStringsAreStrippedOutTest() {
		$commaList = '4,TYPO3,123,1,2';
		$result = $this->fixture->render($commaList);
		$this->assertCount(4, $result);
	}

	/**
	 * @test
	 */
	public function checkIfResultIsNullWhenOnlyAStringIsInTheCommalistTest() {
		$commaList = 'TYPO3';
		$result = $this->fixture->render($commaList);
		$this->assertNull($result);
	}

	/**
	 * @test
	 */
	public function checkIfSpacesInListAreIgnoredTest() {
		$commaList = '4 ,124, 123, 1, 2 ';
		$result = $this->fixture->render($commaList);
		$expectedResult = array('4', '124', '123', '1', '2');
		$this->assertEquals($expectedResult, $result);

	}
}

?>