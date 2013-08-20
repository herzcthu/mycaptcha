<?php
error_reporting(E_ALL);

class MY_CAPTCHA{
	public $captcha;
	private $char_count;
	private $w;
	private $h;
//	function __construct(){
		// Set the enviroment variable for GD
//			putenv('GDFONTPATH=' . realpath('.'));
//		}
	public function my_num($rand){

		//$latin = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'); 
		//$burmese = array('​၀', '​၁', '​၂', '​၃', '​၄', '​၅', '​၆', '​၇', '​၈', '​၉');
		//$rand = str_replace($latin, $burmese, $rand);
		
		switch($rand){
			case 0:
				$burmese = "၀";

				break;
			case 1:
				$burmese = "၁";

				break;
			case 2:
				$burmese = "၂";

				break;
			case 3:
				$burmese = "၃";

				break;
			case 4:
				$burmese = "၄";

				break;
			case 5:
				$burmese = "၅";

				break;
			case 6:
				$burmese = "၆";

				break;
			case 7:
				$burmese = "၇";

				break;
			case 8:
				$burmese = "၈";

				break;
			case 9:
				$burmese = "၉";

				break;
			}	
				$rand = mb_ereg_replace("[0-9]", $burmese, $rand);		
		

		//var_dump($rand);
		return $rand;	
	}
	private function text(){
		$txt = array();
		for($i=1;$i<=$this->char_count;$i++){
		$rand = rand(0,9);
		$txt[] = $this->my_num($rand);
		}
		//var_dump($text);
		return $txt;
	}
	private function gen_img(){


		putenv('GDFONTPATH=' . realpath('.'));

		header ('Content-type: image/png');
		//header ('Content-type: text/html');
		$im = @imagecreatetruecolor($this->w, $this->h)
			  or die('Cannot Initialize new GD image stream');
		$bg = imagecolorallocate($im, 88, 180, 22);
		imagefill($im, 0, 0, $bg);
		$white = imagecolorallocate($im, 255, 255, 255);
		$values = array(
            rand(0, $this->w),  rand(0, $this->h),  // Point 1 (x, y)
            rand(0, $this->w),  rand(0, $this->h), // Point 2 (x, y)
            rand(0, $this->w),  rand(0, $this->h),  // Point 3 (x, y)
            rand(0, $this->w),  rand(0, $this->h),  // Point 4 (x, y)
            rand(0, $this->w),  rand(0, $this->h),  // Point 5 (x, y)
            rand(0, $this->w),  rand(0, $this->h)   // Point 6 (x, y)
            );
		$bgr = rand(0,255);
		$bgg = rand(0,255);
		$bgb = rand(0,255);
		$polybg = imagecolorallocate($im, $bgr, $bgg, $bgb);
		imagefilledpolygon($im, $values, 6, $polybg);
		mb_internal_encoding("UTF-8");
		mb_regex_encoding("UTF-8");
		foreach($this->text as $k => $v){
		$fs = rand(9,13); 
		$a = rand(-35,35);
		$x = 15 * $k + 3;
		$y = 20;
		$r = rand(100,255);
		$g = rand(0,100);
		$b = rand(50,150);
		$text_color = imagecolorallocate($im, $r, $g, $b);
		imagefttext($im,$fs, $a, $x, $y, $text_color, $this->font, $v);
		}
		imageline($im, 0, mt_rand(5, $this->h-5), $this->w, mt_rand(5, $this->w-5), $white);
		imageline($im, mt_rand(10, $this->w-10), 0, 0, mt_rand(10, $this->w-10), $white);
		imagepng($im);
		imagedestroy($im);
	}
	public function captcha($w,$h,$char_count,$font = "ayar"){

		if(gettype($w) == "integer"){
			$this->w = $w;			
		}else{
			$this->w = 120;
		}
		if(gettype($h) == "integer"){
			$this->h = $h;		
		}else{
			$this->h = 30;
		}
		if(gettype($char_count) == "integer"){
			$this->char_count = $char_count;	
		}else{
			$this->char_count = 6;
		}

		$this->font = $font;
		session_start();

		$this->text = $this->text();
		$this->captcha = implode("", $this->text);

		$_SESSION['captcha'] = $this->captcha;
		return $this->gen_img();
	}
}
$captcha = new MY_CAPTCHA();

$captcha->captcha(75,37,5,"AyarNayon");


?>
  ည့့
