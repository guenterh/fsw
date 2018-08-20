/**
 * simple Java script to inject an animation into the HTML code of the Magnolia CMS
 *
 * Copyright (C) Guenter Hipler
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author   Guenter Hipler  <hipler@bluewin.ch>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://www.iwerk.ch
 */

$(document).ready(function(){



    var ranNumber = GetRandom(1,6);
    var imgSRC = "https://www.fsw.uzh.ch/static/img/buchanzeige" + ranNumber + ".png";

    //css of Magnolia for picture links is adding an arrow by default. This is not desirable for the FSW frontpage
    //the simplest way: override it with a not existent image...
    var newHTML = "<a style='background: transparent url(\"test.png\") no-repeat scroll 0 0' href='https://www.fsw.uzh.ch/forschung/publikationen/buchpublikationen.html'>" +
            "<img alt=\"\" src=\""  + imgSRC + "\" width=\"460\"/>" +
            "</a>";

    $("div.mod.mod-text.skin-text-basics").html(newHTML);



});


function GetRandom( min, max ) {
	if( min > max ) {
		return( new Integer(-1) );
	}
	if( min == max ) {
		return( min );
	}
    return( min + parseInt( Math.random() * ( max-min+1 ) ) );
}
