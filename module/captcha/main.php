<?php
return new class(){
    public $tempDir = null;
    public $fontPath = '';
    public $captchaLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	public function __construct(){
        $config = $GLOBALS['module_config'];
        $this->tempDir = core::$library->file->repairPath(core::$path['temp'].'captcha/');
        $this->fontPath = core::$library->file->repairPath($config['path'].'font/arial.ttf');
        if(!file_exists($this->tempDir)){
            mkdir($this->tempDir);
            file_put_contents($this->tempDir.'.htaccess', "<Files *.png>".PHP_EOL."Order deny,allow".PHP_EOL."Allow from all".PHP_EOL."</Files>");
        }
    }
    public function createCaptcha(){
        $captchaWord = null;
        $imagePath = $this->tempDir.$this->_generateImageName().'.png';
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);  
        imagefilledrectangle($image,0,0,200,50,$background_color);
        $line_color = imagecolorallocate($image, 0,0,0); 
        for($i=0;$i<round(rand(2,15),0);$i++)
            imageline($image,0,rand()%50,200,rand()%50,$line_color);
        $pixel_color = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<2500;$i++)
            imagesetpixel($image,rand()%200,rand()%50,"000000");
        $len = strlen($this->captchaLetters);
        $letter = $this->captchaLetters[rand(0, $len-1)];
        $text_color = imagecolorallocate($image, 0,0,0);
        for ($i = 0; $i< 6;$i++) {
            $letter = $this->captchaLetters[rand(0, $len-1)];
            imagettftext(                      // funkcja pisz�ca tekst
            $image,                             // uchwyt obrazka
            rand(17, 32),                     // rozmiar czcionki
            rand(-30, 30),                    // naczylenie znaku
            15+(30*$i),      				  // odleg�o�� mi�dzy znakami
            rand(29, 50),                     // po�o�enie wzgl�dem g�rnej kraw�dzi obrazka
            $text_color,
            $this->fontPath,
            $letter
            );
            $captchaWord.=$letter;
        }
        $_SESSION['captchaString'] = $captchaWord;
        $_SESSION['captchaImagePath'] = $imagePath;
        imagepng($image, $imagePath);
        // $this->clearTempDir();
    }
    private function _generateImageName(){
        return time().round(mt_rand(1111, 9999), 0);
    }
    private function clearTempDir(){
        foreach(glob($this->tempDir."*.png") as $name){
            $explode = explode("/", $name);
            $time = (int)explode(".", $explode[1])[0];
            $time = time()-$time;
            if($time >= 50) unlink($name);
        }
    }
}
?>