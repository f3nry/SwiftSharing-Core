<?php

class Controller_Admin_Ajax extends Controller_Ajax {
	public function action_search() {
		$results = DB::select("id", "firstname", "lastname", "username")
						->from("myMembers")
						->where("username", "LIKE", "%" . $this->request->post('username') . "%")
						->execute()
						->as_array();
		
		return $this->json(array("users" => $results));
	}
}

?>