<?php
return new class() extends core_model{
    public function __construct() {
        $this->loadModel('Interpreter');
    }
	public function read($force=false) {
		core::setError();
		
        foreach (core::$library->database->query('SELECT * FROM jumbotron')->fetchAll(PDO::FETCH_ASSOC) as $item) {
            $jumbotron[$item['name']] = $item['value'];
        }

        if ($force==true) {
            return $jumbotron;
        }

        if (boolval((int)$jumbotron['show']) == false) {
            return false;
        }

        if ($jumbotron['url'] === '') {
            unset($jumbotron['url']);
        } else {
            $jumbotron['url'] = $this->Interpreter->generateLink($jumbotron['url']);
        }

        return $jumbotron;
    }
    public function write($header, $show, $text, $url) {
		core::setError();

        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="header"');
        $prep->bindParam(':text', $header);

        if(!$prep->execute()){
            return core::setError(1);
        }

        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="show"');
        $prep->bindParam(':text', $show);
        
        if(!$prep->execute()){
            return core::setError(2);
        }

        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="text"');
        $prep->bindParam(':text', $text);
        
        if(!$prep->execute()){
            return core::setError(3);
        }

        $prep = core::$library->database->prepare('UPDATE jumbotron SET `value`=:text where `name`="url"');
        $prep->bindParam(':text', $url);
        
        if(!$prep->execute()){
            return core::setError(4);
        }
    }
}
?>