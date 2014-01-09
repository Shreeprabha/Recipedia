<?php
use Zend\Form\Element;
use Zend\Form\Form;

class CreateRecipeForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('recipe');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'recipe_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'creator',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Creator',
            ),
        ));
        $this->addElements();
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
        
    }

    public function addElements()
    {
        $file = new Element\File('image-file');
        $file->setLabel('Image Upload')
             ->setAttribute('id', 'image-file');
        $this->add($file);
    }
}?>