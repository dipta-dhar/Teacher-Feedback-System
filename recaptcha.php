<?php

session_start();

class phptextClass
{	
	
	public function phpcaptcha($textColor, $backgroundColor, $imgWidth, $imgHeight, $length=4, $noiseLines=0,$noiseDots=0,$noiseColor='#162453')
	{	
		/* Settings */

		$text=$this->random($length);
		$textColor=$this->hexToRGB($textColor);	
		$fontSize = $imgHeight * 0.75;
		$font="./font/monofont.ttf";
	
		$im = imagecreatetruecolor($imgWidth, $imgHeight);	
		$textColor = imagecolorallocate($im, $textColor['r'],$textColor['g'],$textColor['b']);			
		
		$backgroundColor = $this->hexToRGB($backgroundColor);
		$backgroundColor = imagecolorallocate($im, $backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']);
				
		if($noiseLines>0)
		{
		$noiseColor=$this->hexToRGB($noiseColor);	
		$noiseColor = imagecolorallocate($im, $noiseColor['r'],$noiseColor['g'],$noiseColor['b']);
		for( $i=0; $i<$noiseLines; $i++ ) 
		{				
			imageline($im, mt_rand(0,$imgWidth), mt_rand(0,$imgHeight),
			mt_rand(0,$imgWidth), mt_rand(0,$imgHeight), $noiseColor);
		}
		}				
				
		if($noiseDots>0)
		{
		for( $i=0; $i<$noiseDots; $i++ ) 
		{
			imagefilledellipse($im, mt_rand(0,$imgWidth),
			mt_rand(0,$imgHeight), 3, 3, $textColor);
		}
		}		
		
		imagefill($im,0,0,$backgroundColor);	
		list($x, $y) = $this->ImageTTFCenter($im, $text, $font, $fontSize);	
		@imagettftext($im, $fontSize, 0, $x, $y, $textColor, $font, $text);		

		header('Content-Type: image/jpeg');
		imagejpeg($im,NULL,90);
		imagedestroy($im);
		$_SESSION['captcha']=$text;
		return;		
	}
	
	protected function random($characters=6,$letters = '23456789bcdfghjkmnpqrstvwxyz'){
		$str='';
		for ($i=0; $i<$characters; $i++) { 
			$str .= $letters[mt_rand(0,strlen($letters)-1)];
		}
		return $str;
	}	
	
	protected function hexToRGB($colour)
	{
			if ( $colour[0] == '#' ) {
					$colour = substr( $colour, 1 );
			}
			if ( strlen( $colour ) == 6 ) {
					list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
			} elseif ( strlen( $colour ) == 3 ) {
					list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
			} else {
					return false;
			}
			$r = hexdec( $r );
			$g = hexdec( $g );
			$b = hexdec( $b );
			return array( 'r' => $r, 'g' => $g, 'b' => $b );
	}		
		
	protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8) 
	{
		$xi = imagesx($image);
		$yi = imagesy($image);
		@$box = imagettfbbox($size, $angle, $font, $text);
		$xr = abs(max($box[2], $box[4]));
		$yr = abs(max($box[5], $box[7]));
		$x = intval(($xi - $xr) / 2);
		$y = intval(($yi + $yr) / 2);
		return array($x, $y);	
	}
}

$p1=new phptextClass();
$p1->phpcaptcha('#162453','#fff',120,40,4,5,50);

?>