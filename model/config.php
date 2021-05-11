<?php
return new class() {
	public $configList;

	public function read(string $name, $default = null) {
		core::setError();

		if (isset($this->configList[$name])) {
			return $this->configList[$name];
		}

		$query = core::$library->database->query('SELECT *, count(*) as count FROM config WHERE name="' . $name . '"')->fetch(PDO::FETCH_ASSOC);

		if ($query['count'] === 0) {
			return $default;
		}

		$this->configList[$name] = $query['value'];
		return $query['value'];
	}

	public function write(string $name, $value) : bool {
		core::setError();

		$sql = 'UPDATE config SET value=:value WHERE name=:name';
		$query = core::$library->database->query('SELECT count(*) as count FROM config WHERE name="' . $name . '"')->fetch(PDO::FETCH_ASSOC);

		if ($query['count'] === 0) {
			$sql = 'INSERT INTO config (value, name) VALUES (:value, :name)';
		}

		$prep = core::$library->database->prepare($sql);
		$prep->bindParam(':value', $value);
		$prep->bindParam(':name', $name);

		if (!$prep->execute()) {
			return false;
		}

		$this->configList[$name] = $value;
		return true;
	}

	public function getAllConfigArray() : array {
		core::setError();

		$config = [];
		$query = core::$library->database->query('SELECT name, value FROM config')->fetchAll(PDO::FETCH_ASSOC);

		foreach ($query as $value) {
			$config[$value['name']] = $value['value'];
		}

		$this->configList = $config;

		return $config;
	}
};