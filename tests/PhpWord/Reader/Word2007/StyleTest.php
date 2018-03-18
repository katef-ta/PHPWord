<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Reader\Word2007;

use PhpOffice\PhpWord\AbstractTestReader;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Style\Table;
use PhpOffice\PhpWord\Style\TablePosition;

/**
 * Test class for PhpOffice\PhpWord\Reader\Word2007\Styles
 */
class StyleTest extends AbstractTestReader
{
    /**
     * Test reading of table layout
     */
    public function testReadTableLayout()
    {
        $documentXml = '<w:tbl>
            <w:tblPr>
                <w:tblLayout w:type="fixed"/>
            </w:tblPr>
        </w:tbl>';

        $phpWord = $this->getDocumentFromString(array('document' => $documentXml));

        $elements = $phpWord->getSection(0)->getElements();
        $this->assertInstanceOf('PhpOffice\PhpWord\Element\Table', $elements[0]);
        $this->assertInstanceOf('PhpOffice\PhpWord\Style\Table', $elements[0]->getStyle());
        $this->assertEquals(Table::LAYOUT_FIXED, $elements[0]->getStyle()->getLayout());
    }

    /**
     * Test reading of cell spacing
     */
    public function testReadCellSpacing()
    {
        $documentXml = '<w:tbl>
            <w:tblPr>
                <w:tblCellSpacing w:w="10.5" w:type="dxa"/>
            </w:tblPr>
        </w:tbl>';

        $phpWord = $this->getDocumentFromString(array('document' => $documentXml));

        $elements = $phpWord->getSection(0)->getElements();
        $this->assertInstanceOf('PhpOffice\PhpWord\Element\Table', $elements[0]);
        $this->assertInstanceOf('PhpOffice\PhpWord\Style\Table', $elements[0]->getStyle());
        /** @var \PhpOffice\PhpWord\Style\Table $tableStyle */
        $tableStyle = $elements[0]->getStyle();
        $this->assertEquals(TblWidth::AUTO, $tableStyle->getUnit());
        $this->assertEquals(10.5, $tableStyle->getCellSpacing());
    }

    /**
     * Test reading of table position
     */
    public function testReadTablePosition()
    {
        $documentXml = '<w:tbl>
            <w:tblPr>
                <w:tblpPr w:leftFromText="10" w:rightFromText="20" w:topFromText="30" w:bottomFromText="40" w:vertAnchor="page" w:horzAnchor="margin" w:tblpXSpec="center" w:tblpX="50" w:tblpYSpec="top" w:tblpY="60"/>
            </w:tblPr>
        </w:tbl>';

        $phpWord = $this->getDocumentFromString(array('document' => $documentXml));

        $elements = $phpWord->getSection(0)->getElements();
        $this->assertInstanceOf('PhpOffice\PhpWord\Element\Table', $elements[0]);
        $this->assertInstanceOf('PhpOffice\PhpWord\Style\Table', $elements[0]->getStyle());
        $this->assertNotNull($elements[0]->getStyle()->getPosition());
        $this->assertInstanceOf('PhpOffice\PhpWord\Style\TablePosition', $elements[0]->getStyle()->getPosition());
        /** @var \PhpOffice\PhpWord\Style\TablePosition $tableStyle */
        $tableStyle = $elements[0]->getStyle()->getPosition();
        $this->assertEquals(10, $tableStyle->getLeftFromText());
        $this->assertEquals(20, $tableStyle->getRightFromText());
        $this->assertEquals(30, $tableStyle->getTopFromText());
        $this->assertEquals(40, $tableStyle->getBottomFromText());
        $this->assertEquals(TablePosition::VANCHOR_PAGE, $tableStyle->getVertAnchor());
        $this->assertEquals(TablePosition::HANCHOR_MARGIN, $tableStyle->getHorzAnchor());
        $this->assertEquals(TablePosition::XALIGN_CENTER, $tableStyle->getTblpXSpec());
        $this->assertEquals(50, $tableStyle->getTblpX());
        $this->assertEquals(TablePosition::YALIGN_TOP, $tableStyle->getTblpYSpec());
        $this->assertEquals(60, $tableStyle->getTblpY());
    }

    /**
     * Test reading of position
     */
    public function testReadPosition()
    {
        $documentXml = '<w:p>
            <w:r>
                <w:rPr>
                    <w:position w:val="15"/>
                </w:rPr>
                <w:t xml:space="preserve">This text is lowered</w:t>
            </w:r>
        </w:p>';

        $phpWord = $this->getDocumentFromString(array('document' => $documentXml));

        $elements = $phpWord->getSection(0)->getElements();
        /** @var \PhpOffice\PhpWord\Element\TextRun $elements */
        $textRun = $elements[0];
        $this->assertInstanceOf('PhpOffice\PhpWord\Element\TextRun', $textRun);
        $this->assertInstanceOf('PhpOffice\PhpWord\Element\Text', $textRun->getElement(0));
        $this->assertInstanceOf('PhpOffice\PhpWord\Style\Font', $textRun->getElement(0)->getFontStyle());
        /** @var \PhpOffice\PhpWord\Style\Font $fontStyle */
        $fontStyle = $textRun->getElement(0)->getFontStyle();
        $this->assertEquals(15, $fontStyle->getPosition());
    }
}