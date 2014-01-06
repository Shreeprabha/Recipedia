<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Recipe\Controller\Recipe' => 'Recipe\Controller\RecipeController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'recipe' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/recipe[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Recipe\Controller\Recipe',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'recipe' => __DIR__ . '/../view',
        ),
    ),
);
?>