<?php namespace Prismify\Portfolio\Components;

use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Prismify\Portfolio\Models\Project as PortfolioProject;
use Prismify\Portfolio\Models\Industry as PortfolioIndustry;

class Projects extends ComponentBase
{
    /**
     * A collection of projects to display
     * @var Collection
     */
    public $projects;

    /**
     * Parameter to use for the page number
     * @var string
     */
    public $pageParam;

    /**
     * If the project list should be filtered by a industries, the model to use.
     * @var Model
     */
    public $industry;

    /**
     * Message to display when there are no messages.
     * @var string
     */
    public $noProjectsMessage;

    /**
     * Reference to the page name for linking to projects.
     * @var string
     */
    public $projectPage;

    /**
     * Reference to the page name for linking to industries.
     * @var string
     */
    public $industryPage;

    /**
     * If the project list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    public function componentDetails()
    {
        return [
            'name'        => 'prismify.portfolio::lang.components.projects.details.name',
            'description' => 'prismify.portfolio::lang.components.projects.details.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'pageNumber' => [
                'title'       => 'prismify.portfolio::lang.components.projects.properties.page_number.title',
                'description' => 'prismify.portfolio::lang.components.projects.properties.page_number.description',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'industryFilter' => [
                'title'       => 'prismify.portfolio::lang.components.projects.properties.filter.title',
                'description' => 'prismify.portfolio::lang.components.projects.properties.filter.description',
                'type'        => 'string',
                'default'     => ''
            ],
            'projectsPerPage' => [
                'title'             => 'prismify.portfolio::lang.components.projects.properties.per_page.title',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'prismify.portfolio::lang.components.projects.properties.per_page.validation',
                'default'           => '10',
            ],
            'noProjectsMessage' => [
                'title'        => 'prismify.portfolio::lang.components.projects.properties.no_message.title',
                'description'  => 'prismify.portfolio::lang.components.projects.properties.no_message.description',
                'type'         => 'string',
                'default'      => 'No projects found',
                'showExternalParam' => false
            ],
            'sortOrder' => [
                'title'       => 'prismify.portfolio::lang.components.projects.properties.sort_order.title',
                'description' => 'prismify.portfolio::lang.components.projects.properties.sort_order.description',
                'type'        => 'dropdown',
                'default'     => 'published_at desc'
            ],
            'industryPage' => [
                'title'       => 'prismify.portfolio::lang.components.projects.properties.industry_page.title',
                'description' => 'prismify.portfolio::lang.components.projects.properties.industry_page.description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/industry',
                'group'       => 'prismify.portfolio::lang.components.projects.properties.industry_page.group',
            ],
            'projectPage' => [
                'title'       => 'prismify.portfolio::lang.components.projects.properties.project_page.title',
                'description' => 'prismify.portfolio::lang.components.projects.properties.project_page.description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/project',
                'group'       => 'prismify.portfolio::lang.components.projects.properties.project_page.group',
            ],
        ];
    }

    public function getIndustryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getProjectPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getSortOrderOptions()
    {
        return PortfolioProject::$allowedSortingOptions;
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->industry = $this->page['industry'] = $this->loadIndustry();
        $this->projects = $this->page['projects'] = $this->listProjects();

        /*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->projects->lastPage()) && $currentPage > 1)
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
        }
    }

    protected function prepareVars()
    {
        $this->pageParam = $this->page['pageParam'] = $this->paramName('pageNumber');
        $this->noProjectsMessage = $this->page['noProjectsMessage'] = $this->property('noProjectsMessage');

        /*
         * Page links
         */
        $this->projectPage = $this->page['projectPage'] = $this->property('projectPage');
        $this->industryPage = $this->page['industryPage'] = $this->property('industryPage');
    }

    protected function listProjects()
    {
        $industry = $this->industry ? $this->industry->id : null;

        /*
         * List all the projects, eager load their industries
         */
        $isPublished = true;

        $projects = PortfolioProject::with('industries')->listFrontEnd([
            'page'       => $this->property('pageNumber'),
            'sort'       => $this->property('sortOrder'),
            'perPage'    => $this->property('projectsPerPage'),
            'search'     => trim(input('search')),
            'industry'   => $industry,
            'published'  => $isPublished,
        ]);

        /*
         * Add a "url" helper attribute for linking to each project and industry
         */
        $projects->each(function($project) {
            $project->setUrl($this->projectPage, $this->controller);

            $project->industries->each(function($industry) {
                $industry->setUrl($this->industryPage, $this->controller);
            });
        });

        return $projects;
    }

    protected function loadIndustry()
    {
        if (!$slug = $this->property('industryFilter')) {
            return null;
        }

        $industry = new PortfolioIndustry();

        $industry = $industry->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $industry->transWhere('slug', $slug)
            : $industry->where('slug', $slug);

        $industry = $industry->first();

        return $industry ?: null;
    }

}
