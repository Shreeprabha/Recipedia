<?php
namespace Recipe\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;

class RecipeTable extends AbstractTableGateway {

    protected $table = 'recipe';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    
    public function fetchAll() {
        $resultSet = $this->select(function (Select $select) {
                    $select->order('created ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Recipe();
            $entity->setId($row->id)
                    ->setNote($row->note)
                    ->setCreated($row->created);
            $entities[] = $entity;
        }
        return $entities;
    }

    public function getRecipe($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $recipe = new Recipe(array(
                    'id' => $row->id,
                    'note' => $row->note,
                    'created' => $row->created,
                ));
        return $recipe;
    }

    public function saveRecipe(Recipe $recipe) {
        $data = array(
            'note' => $recipe->getNote(),
            'created' => $recipe->getCreated(),
        );

        $id = (int) $recipe->getId();

        if ($id == 0) {
            $data['created'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getRecipe($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }
    
    public function removeRecipe($id) {
        return $this->delete(array('id' => (int) $id));
    }
    
}?>