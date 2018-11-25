<?php namespace Prismify\Portfolio\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Reviews Back-end Controller
 */
class Reviews extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['prismify.portfolio.access_reviews'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Prismify.Portfolio', 'portfolio', 'reviews');
    }
}
