<?php
return new class(){
	public function generate($array, $autoIncludeAllGet = false, array $unsetData = []){
		core::setError();
		$arrayData = '';
		if($autoIncludeAllGet == true){
			foreach($_GET as $name => $value){
				if(!isset($array[$name]))
					$array[$name] = $value;
			}
		}
		if(count($unsetData) > 0)
			foreach($unsetData as $name)
				unset($array[$name]);
		foreach($array as $name => $value){
			if (is_int($name)) {
				if(!isset($_GET[$value]))
					continue;
				$arrayData .= ($arrayData==''?'':'&').$value.'='.$_GET[$value];
			} else
				$arrayData .= ($arrayData==''?'':'&').$name.'='.$value;
		}
		return 'index.php?'.$arrayData;
	}
	public function generateAP($array=[]){
		core::setError();
		$arrayData = '';
		foreach($array as $name => $value){
			if (is_int($name)) {
				if(!isset($_GET[$value]))
					continue;
				$arrayData .= ($arrayData==''?'':'&').$value.'='.$_GET[$value];
			}else
				$arrayData .= ($arrayData==''?'':'&').$name.'='.$value;
		}
		if(isset($_GET['modul'])){
			if($arrayData <> "") $arrayData = '?'.$arrayData;
			return 'FrameworkModuleAP-'.$_GET['modul'].'.html'.$arrayData;
		}else
		return 'index.html?'.$arrayData;
	}
}
?>