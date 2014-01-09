<?php
namespace Recipe\Model;
//use RedBean_SimpleModel;

class Recipe {
	protected $recipe_id;
	protected $name;
	protected $creator;
	protected $dir_path;
	
	public function __construct(array $data = null) {
		if (is_array($data) && $data != null) {
			$this->_recipe_id	= (isset($data['recipe_id'])) ? $data['recipe_id'] : null;
			$this->_creator = (isset($data['creator'])) ? $data['creator'] : null;
			$this->_name = (isset($data['name'])) ? $data['name'] : null;
			$this->_dir_path = (isset($data['dir_path'])) ? $data['dir_path'] : null;
		}
	}
	
	public function getId() {
		return $this->recipe_id;
	}
	
	public function setId($recipe_id) {
		$this->recipe_id = $recipe_id;
		return $this;
	}
	
	public function getCreator() {
		return $this->creator;
	}
	
	public function setCreator($creator) {
		$this->creator = $creator;
		return $this;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getDirPath() {
		return $this->dir_path;
	}
	
	public function setDirPath(array $dir_path = null) {
		if(is_array($dir_path) && $dir_path != null)
			$this->dir_path = $dir_path;
		return $this;
	}
}?>