<?php
return new class() {
	public $configList;

	public function read(string $name, $default = null, $userId = -1) {
		core::setError();

		if (isset($this->configList[$name])) {
			return $this->configList[$name];
		}

		if ($userId === -1) {
			$userId = core::$module->account->userData['id'];
		}

		$query = core::$library->database->query('SELECT *, count(*) as count FROM user_option WHERE name="' . $name . '"  and userID=" ' . $userId . '"')->fetch(PDO::FETCH_ASSOC);

		if ($query['count'] === 0) {
			return $default;
		}

		$this->configList[$name] = $query['value'];
		return $query['value'];
	}

	public function write(string $name, $value, $userId = -1) : bool {
		core::setError();

		if ($userId === -1) {
			$userId = (int)core::$module->account->userData['id'];
		}

		$sql = 'UPDATE user_option SET value=:value WHERE name=:name AND userID=:userID';
		$query = core::$library->database->query('SELECT count(*) as count FROM user_option WHERE name="' . $name . '" and userID=" ' . $userId . '"')->fetch(PDO::FETCH_ASSOC);

		if ($query['count'] === 0) {
			$sql = 'INSERT INTO user_option (value, name, userID) VALUES (:value, :name, :userID)';
		}

		$prep = core::$library->database->prepare($sql);
		$prep->bindParam(':value', $value);
		$prep->bindParam(':name', $name);
		$prep->bindParam(':userID', $userId);

		if (!$prep->execute()) {
			return false;
		}

		$this->configList[$name] = $value;

		return true;
	}
};