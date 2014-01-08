<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;

class UserTable extends AbstractTableGateway {

    protected $table = 'user';

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
                    ->setName($row->note)
                    ->setEmail($row->created);
                    ->setPic($row->pic);
            $entities[] = $entity;
        }
        return $entities;
    }

    public function getUser($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $user = new User(array(
                    'id' => $row->id,
                    'name' => $row->name,
                    'email' => $row->email,
                    'pic' =>$row->pic,
                ));
        return $user;
    }

    public function saveUser(User $user) {
        $data = array(
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'pic'  => $user->getPic(),
        );

        $id = (int) $user->getId();

        if ($id == 0) {
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getUser($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }
    
    public function removeUser($email) {
        return $this->delete(array('email' => $email));
    }
    
}?>