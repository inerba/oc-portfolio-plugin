<?php namespace Prismify\Portfolio\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Industries Back-end Controller
 */
class Industries extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['prismify.portfolio.access_industries'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Prismify.Portfolio', 'portfolio', 'industries');
    }

    public function create()
    {
        $this->bodyClass = 'compact-container';
        return $this->asExtension('FormController')->create();
    }

    public function update($recordId = null)
    {
        $this->bodyClass = 'compact-container';
        return $this->asExtension('FormController')->update($recordId);
    }
}
