<?php
return new class() {
	public function protectID($id) : int {
		core::setError();

		return (int)trim(htmlspecialchars($id));
	}
};