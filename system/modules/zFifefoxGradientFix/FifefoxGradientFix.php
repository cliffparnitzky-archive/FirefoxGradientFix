<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
* Contao Open Source CMS
* Copyright (C) 2005-2012 Leo Feyer
*
* Formerly known as TYPOlight Open Source CMS.
*
* This program is free software: you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation, either
* version 3 of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this program. If not, please visit the Free
* Software Foundation website at <http://www.gnu.org/licenses/>.
*
* PHP version 5
* @copyright  Cliff Parnitzky 2012
* @author     Cliff Parnitzky
* @package    FifefoxGradientFix
* @license    LGPL
*/

/**
* Class FifefoxGradientFix
*
* Fixes a gradient change in firefox.
* @copyright  Cliff Parnitzky 2012
* @author     Cliff Parnitzky
*/
class FifefoxGradientFix {
	/**
	* Adds translated css and javascript for the footer
	*/
	public function fixGradient($row, $blnWriteToFile, $vars)
	{
		if ($row['gradientAngle'] != '' && $row['gradientColors'] != '')
		{
			$row['gradientColors'] = deserialize($row['gradientColors']);

			if (is_array($row['gradientColors']) && count(array_filter($row['gradientColors'])) > 0)
			{
				$bgImage = '';

				// CSS3 PIE only supports -pie-background, so if there is a background image, include it here, too.
				if ($row['bgimage'] != '' && $row['bgposition'] != '' && $row['bgrepeat'] != '')
				{
					$glue = (strncmp($row['bgimage'], 'data:', 5) !== 0 && strncmp($row['bgimage'], 'http://', 7) !== 0 && strncmp($row['bgimage'], 'https://', 8) !== 0 && strncmp($row['bgimage'], '/', 1) !== 0) ? $strGlue : '';
					$bgImage = 'url("' . $glue . $row['bgimage'] . '") ' . $row['bgposition'] . ' ' . $row['bgrepeat'] . ',';
				}
				
				$gradientAngel = $row['gradientAngle'];
				if (strpos("deg", $gradientAngel) >= 0) {
					preg_match("/\d+/", $gradientAngel, $gradientAngelVal);
					$gradientAngelVal = $gradientAngelVal[0];
					if (strpos("-", $gradientAngel) == 0) {
						$gradientAngelVal = $gradientAngelVal * (-1);
					}
					$gradientAngelVal = $gradientAngelVal - 90;
					if ($gradientAngelVal > 360) {
						$gradientAngelVal = $gradientAngelVal - 360;
					}
					$gradientAngel  = $gradientAngelVal . "deg";
				}
				
				$gradient = $gradientAngel . ',' . implode(',', $row['gradientColors']);
				return 'background:' . $bgImage . 'linear-gradient(' . $gradient . ');';
			}
		}
	 
		return "";
	}
}

?>