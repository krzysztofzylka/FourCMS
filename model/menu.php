<?php
return new class() extends core_model {
	public function __construct() {
		$this->loadModel('Interpreter');
	}

	public function read(int $id = -1) {
		core::setError();

		if ($id <> -1) {
			return core::$library->database->query('SELECT * FROM menu WHERE id=' . $id)->fetch(PDO::FETCH_ASSOC);
		}

		foreach (core::$library->database->query('SELECT * FROM menu ORDER BY position ASC')->fetchAll(PDO::FETCH_ASSOC) as $item) {
			$menu[$item['name']] = $this->Interpreter->generateLink($item['link']);
		}

		if (!isset($menu)) {
			return false;
		}

		return $menu;
	}

	public function list() {
		core::setError();

		return core::$library->database->query('SELECT * FROM menu ORDER BY position ASC')->fetchAll(PDO::FETCH_ASSOC);
	}

	public function positionUp(int $id) : bool {
		core::setError();

		$item = $this->read($id);

		if ($item['position'] - 1 < 0) {
			return false;
		}

		core::$library->database->exec('UPDATE menu SET position = position-1 WHERE id=' . $id);
		core::$library->database->exec('UPDATE menu SET position = position+1 WHERE position=' . ($item['position'] - 1) . ' and id<>' . $id);

		return true;
	}

	public function positionDown(int $id) : bool {
		core::setError();

		$item = $this->read($id);
		$count = core::$library->database->query('SELECT count(*) as count FROM menu')->fetch(PDO::FETCH_ASSOC);

		if ((int)$item['position'] + 1 > (int)$count['count']) {
			return false;
		}

		core::$library->database->exec('UPDATE menu SET position = position+1 WHERE id=' . $id);
		core::$library->database->exec('UPDATE menu SET position = position-1 WHERE position=' . ($item['position'] + 1) . ' and id<>' . $id);

		return true;
	}

	public function delete(int $menuId) : bool {
		core::setError();

		$menu = $this->read($menuId);

		$prepare = core::$library->database->prepare('DELETE FROM menu WHERE id=:id');
		$prepare->bindParam(':id', $menuId, PDO::PARAM_INT);

		if (!$prepare->execute()) {
			return false;
		}

		$prepare = core::$library->database->prepare('UPDATE menu SET position = position-1 WHERE position>:menuPosition');
		$prepare->bindParam(':menuPosition', $menu['position'], PDO::PARAM_INT);

		if (!$prepare->execute()) {
			return false;
		}

		return true;
	}

	public function write(int $id, string $name, string $link) : bool {
		core::setError();

		$prep = core::$library->database->prepare('UPDATE menu SET `name`=:name, `link`=:link where `id`=:id');
		$prep->bindParam(':name', $name, PDO::PARAM_STR);
		$prep->bindParam(':link', $link, PDO::PARAM_STR);
		$prep->bindParam(':id', $id, PDO::PARAM_INT);

		if ($prep->execute()) {
			return core::setError(1);
		}

		return true;
	}

	public function create(string $name, string $link) : bool {
		core::setError();

		$position = (int)core::$library->database->query('SELECT count(*) as count FROM menu')->fetch(PDO::FETCH_ASSOC)['count'];
		$prep = core::$library->database->prepare('INSERT INTO menu (`name`, `link`, `position`) VALUES (:name, :link, :position)');
		$prep->bindParam(':name', $name, PDO::PARAM_STR);
		$prep->bindParam(':link', $link, PDO::PARAM_STR);
		$prep->bindParam(':position', $position, PDO::PARAM_INT);

		try {
			$prep->execute();
		} catch (PDOException $err) {
			return core::setError(1, 'SQL Execute Error', $e->getMessage());
		}

		return true;
	}
};