<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class UploadRecipeImageForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('UploadRecipeImage');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
         
        $this->add(array(
            'name' => 'recipename',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Please enter the Recipe Name',
            ),
        ));
 
         
        $this->add(array(
            'name' => 'fileupload',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'Upload Recipe image',
            ),
        )); 
         
         
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload Now'
            ),
        )); 
    }
}