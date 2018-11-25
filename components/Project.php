<?php namespace Prismify\Portfolio\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Prismify\Portfolio\Models\Project as PortfolioProject;


class Project extends ComponentBase
{
    /**
     * @var Prismify\Portfolio\Models\Project The project model used for display.
     */
    public $project;

    /**
     * @var string Reference to the page name for linking to industries.
     */
    public $industryPage;

    public function componentDetails()
    {
        return [
            'name'        => 'prismify.portfolio::lang.components.project.details.name',
            'description' => 'prismify.portfolio::lang.components.project.details.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'prismify.portfolio::lang.components.project.properties.slug.title',
                'description' => 'prismify.portfolio::lang.components.project.properties.slug.description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'industryPage' => [
                'title'       => 'prismify.portfolio::lang.components.project.properties.industry_page.title',
                'description' => 'prismify.portfolio::lang.components.project.properties.industry_page.description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/industry',
                'group'       => 'prismify.portfolio::lang.components.projects.properties.industry_page.group',
            ],
        ];
    }

    public function getIndustryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->industryPage = $this->page['industryPage'] = $this->property('industryPage');
        $this->project = $this->page['project'] = $this->loadProject();
    }

    public function onRender()
    {
        if (empty($this->project)) {
            $this->project = $this->page['project'] = $this->loadProject();
        }
    }

    protected function loadProject()
    {
        $slug = $this->property('slug');

        $project = new PortfolioProject;

        $project = $project->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $project->transWhere('slug', $slug)
            : $project->where('slug', $slug);

        $project = $project->isPublished();

        $project = $project->first();

        /*
         * Add a "url" helper attribute for linking to each industry
         */
        if ($project && $project->industries->count()) {
            $project->industries->each(function($industry) {
                $industry->setUrl($this->industryPage, $this->controller);
            });
        }

        return $project;
    }

}
