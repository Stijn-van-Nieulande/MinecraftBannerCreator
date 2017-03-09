<?php

/*
	Minecraft Banner Generator
	Copyright (C) 2017  Stijn van Nieulande <https://stijndevelopment.nl>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class MinecraftBannerCreator {
	
	private $dyeColors = array(
	//	COLOR					 R		G		B		Y
		"BLACK"			=> array("25",	"25",	"25",	"2340"),
		"BLUE"			=> array("51",	"76",	"178",	"1716"),
		"BROWN"			=> array("102",	"76",	"51",	"1872"),
		"CYAN"			=> array("76",	"127",	"153",	"1404"),
		"GRAY"			=> array("76",	"76",	"76",	"1092"),
		"GREEN"			=> array("102",	"127",	"51",	"2028"),
		"LIGHT_BLUE"	=> array("102",	"153",	"216",	"468"),
		"LIME"			=> array("127",	"204",	"25",	"780"),
		"MAGENTA"		=> array("178",	"76",	"216",	"312"),
		"ORANGE"		=> array("216",	"127",	"51",	"156"),
		"PINK"			=> array("242",	"127",	"165",	"936"),
		"PURPLE"		=> array("127",	"63",	"178",	"1560"),
		"RED"			=> array("153",	"51",	"51",	"2184"),
		"SILVER"		=> array("153",	"153",	"153",	"1248"),
		"WHITE"			=> array("255",	"255",	"255",	"0"),
		"YELLOW"		=> array("229",	"229",	"51",	"624")
	);
	
	private $patternTypes = array(
	//	TYPE						   X
		"SQUARE_BOTTOM_LEFT"		=> "160",
		"SQUARE_BOTTOM_RIGHT"		=> "240",
		"SQUARE_TOP_LEFT"			=> "320",
		"SQUARE_TOP_RIGHT"			=> "400",
		"STRIPE_BOTTOM"				=> "560",
		"STRIPE_TOP"				=> "640",
		"STRIPE_LEFT"				=> "800",
		"STRIPE_RIGHT"				=> "960",
		"STRIPE_CENTER"				=> "880",
		"STRIPE_MIDDLE"				=> "1040",
		"STRIPE_DOWNRIGHT"			=> "1280",
		"STRIPE_DOWNLEFT"			=> "1200",
		"STRIPE_SMALL"				=> "2160",
		"CROSS"						=> "1360",
		"STRAIGHT_CROSS"			=> "1120",
		"TRIANGLE_BOTTOM"			=> "1680",
		"TRIANGLE_TOP"				=> "1600",
		"TRIANGLES_BOTTOM"			=> "1920",
		"TRIANGLES_TOP"				=> "1840",
		"DIAGONAL_LEFT"				=> "1440",
		"DIAGONAL_RIGHT"			=> "1520",
		"DIAGONAL_LEFT_MIRROR"		=> "2720",
		"DIAGONAL_RIGHT_MIRROR"		=> "2800",
		"CIRCLE_MIDDLE"				=> "80",
		"RHOMBUS_MIDDLE"			=> "1760",
		"HALF_VERTICAL"				=> "720",
		"HALF_HORIZONTAL"			=> "480",
		"HALF_VERTICAL_MIRROR"		=> "3040",
		"HALF_HORIZONTAL_MIRROR"	=> "2960",
		"BORDER"					=> "2080",
		"CURLY_BORDER"				=> "2000",
		"CREEPER"					=> "2400",
		"GRADIENT"					=> "2320",
		"GRADIENT_UP"				=> "2880",
		"BRICKS"					=> "2240",
		"SKULL"						=> "2480",
		"FLOWER"					=> "2560",
		"MOJANG"					=> "2640",
	);
	
	private $outputs = array(
		"PNG", "BASE64", "RETURN"
	);
	
	private $base_color	= "WHITE";
	private $layers		= array();
	private $output		= "PNG";
	
	public function setOutput($output) {
		if (array_key_exists($output, $this->outputs)) {
			$this->output = $output;
		}
	}
	
	public function setBaseColor($dyeColor) {
		if (array_key_exists($dyeColor, $this->dyeColors)) {
			$this->base_color = $dyeColor;
		}
	}
	
	public function addPattern($dyeColor, $patternType) {
		if (array_key_exists($dyeColor, $this->dyeColors) && array_key_exists($patternType, $this->patternTypes)) {
			array_push($this->layers, array($dyeColor, $patternType));
		}
	}
	
	public function create() {
		$width	= 80;
		$height	= 156;
		$im		= imagecreatetruecolor($width, $height);

		// Base
		$dyeColor	= $this->dyeColors[$this->base_color];
		$bg_color	= imagecolorallocate($im, $dyeColor[0], $dyeColor[1], $dyeColor[2]);
		imagefill($im, 0, 0, $bg_color);

		// Layers
		foreach ($this->layers as &$layer) {			
			$src_x = $this->patternTypes[$layer[1]];
			$src_y = $this->dyeColors[$layer[0]][3];
			imagecopyresampled($im, imagecreatefrompng("banners.png"), 0, 0, $src_x, $src_y, $width, $height, $width, $height);
		}
		
		// Shadow
		imagecopyresampled($im, imagecreatefrompng("banner-shadow.png"), 0, 0, 0, 0, $width, $height, $width, $height);
		
		switch ($this->output) {
			case "RETURN":
				return $im;
				break;
			case "BASE64":
				header('Content-Type: text/plain');
				echo $im;
				break;
			case "PNG":
			default:
				header('Content-type: image/png');
				imagepng($im);
				imagedestroy($im);
				break;
		}
	}
	
}