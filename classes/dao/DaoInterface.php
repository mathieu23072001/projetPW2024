<?php
interface DaoInterface {
public function create ($object);
public function modify ($object);
public function delete ($object);
public function list ();
}


?>