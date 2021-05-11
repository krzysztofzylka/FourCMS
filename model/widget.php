<?php
return new class() {
	public $widgetList = [];

	public function __construct() {
		core::setError();
		$data = include('panelData/_list.php');

		foreach ($data as $widgetData) {
			$this->addWidget($widgetData['uniqueID'], $widgetData['name'], $widgetData['description'], $widgetData['widgetPath']);
		}
	}

	public function addWidget(string $uniqueID, string $name, string $description, string $widgetPath, string $moduleName = null) : bool {
		core::setError();

		if (isset($this->widgetList[$uniqueID])) {
			return false;
		}

		$this->widgetList[$uniqueID] = [
			'uniqueID' => $uniqueID,
			'name' => $name,
			'description' => $description,
			'widgetPath' => $widgetPath,
			'moduleName' => $moduleName
		];

		return true;
	}

	public function getWidgetData(string $uniqueID) {
		core::setError();

		return $this->widgetList[$uniqueID] ?? false;
	}

	public function userAddWidget(int $userID, string $uniqueID) : bool {
		core::setError();

		if (!isset($this->widgetList[$uniqueID])) {
			return core::setError(2, 'not fount in list (' . $uniqueID . ')');
		}

		$position = (int)core::$library->database->countRow('widget', 'userID=' . $userID) + 1;
		$prepare = core::$library->database->prepare('INSERT INTO widget (userID, uniqueIDWidget, position) VALUES (:userID, :widgetID, :position)');
		$prepare->bindParam(':userID', $userID, PDO::PARAM_INT);
		$prepare->bindParam(':widgetID', $uniqueID, PDO::PARAM_STR);
		$prepare->bindParam(':position', $position, PDO::PARAM_INT);

		if (!$prepare->execute()) {
			return core::setError('1', 'PDO Error', $prepare->errorInfo());
		}

		return true;
	}

	public function getUserWidget(int $userID, int $widgetID = null) {
		core::setError();

		if ($widgetID === null) {
			$prepare = core::$library->database->prepare('SELECT * FROM widget WHERE userID=:userID ORDER BY position');
			$prepare->bindParam(':userID', $userID, PDO::PARAM_INT);

			if (!$prepare->execute()) {
				return false;
			}

			return $prepare->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$prepare = core::$library->database->prepare('SELECT * FROM widget WHERE id=:widgetID and userID=:userID LIMIT 1');
			$prepare->bindParam(':userID', $userID, PDO::PARAM_INT);
			$prepare->bindParam(':widgetID', $widgetID, PDO::PARAM_INT);

			if (!$prepare->execute()) {
				return false;
			}

			return $prepare->fetch(PDO::FETCH_ASSOC);
		}
	}

	public function positionUp(int $widgetID, int $userID) : bool {
		core::setError();

		$item = $this->getUserWidget($userID, $widgetID);

		if (!$item) {
			return false;
		}

		if ($item['position'] - 1 < 1) {
			return false;
		}

		core::$library->database->exec('UPDATE widget SET position = position-1 WHERE id=' . $widgetID . ' and userID=' . $userID);
		core::$library->database->exec('UPDATE widget SET position = position+1 WHERE position=' . ($item['position'] - 1) . ' and id<>' . $widgetID . ' and userID=' . $userID);

		return true;
	}

	public function positionDown(int $widgetID, int $userID) : bool {
		core::setError();

		$item = $this->getUserWidget($userID, $widgetID);

		if (!$item) {
			return false;
		}

		$count = core::$library->database->query('SELECT count(*) as count FROM widget WHERE userID=' . $userID)->fetch(PDO::FETCH_ASSOC);

		if ((int)$item['position'] + 1 > (int)$count['count']) {
			return false;
		}

		core::$library->database->exec('UPDATE widget SET position = position+1 WHERE id=' . $widgetID . ' and userID=' . $userID);
		core::$library->database->exec('UPDATE widget SET position = position-1 WHERE position=' . ($item['position'] + 1) . ' and id<>' . $widgetID . ' and userID=' . $userID);

		return true;
	}

	public function deleteUserWidget(int $widgetID, int $userID) : bool {
		core::setError();

		$item = $this->getUserWidget($userID, $widgetID);

		if (!$item) {
			return false;
		}

		$prepare = core::$library->database->prepare('DELETE FROM widget WHERE userID=:userID and id=:widgetID');
		$prepare->bindParam(':userID', $userID, PDO::PARAM_INT);
		$prepare->bindParam(':widgetID', $widgetID, PDO::PARAM_INT);

		if (!$prepare->execute()) {
			return false;
		}

		core::$library->database->exec('UPDATE widget SET position = position-1 WHERE userID=' . $userID . ' and position>' . $item['position']);

		return true;
	}
};