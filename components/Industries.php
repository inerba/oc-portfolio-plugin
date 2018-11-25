<?php namespace Prismify\Portfolio\Components;

use Db;
use App;
use Request;
use Carbon\Carbon;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Prismify\Portfolio\Models\Industry as PortfolioIndustry;

class Industries extends ComponentBase
{
    /**
     * @var Collection A collection of industries to display
     */
    public $industries;

    /**
     * @var string Reference to the page name for linking to industries.
     */
    public $industryPage;

    public function componentDetails()
    {
        return [
            'name'        => 'prismify.portfolio::lang.components.industries.details.name',
            'description' => 'prismify.portfolio::lang.components.industries.details.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'prismify.portfolio::lang.components.industries.properties.slug.title',
                'description' => 'prismify.portfolio::lang.components.industries.properties.slug.description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'displayEmpty' => [
                'title'       => 'prismify.portfolio::lang.components.industries.properties.display_empty.title',
                'description' => 'prismify.portfolio::lang.components.industries.properties.display_empty.description',
                'type'        => 'checkbox',
                'default'     => 0
            ],
            'industryPage' => [
                'title'       => 'prismify.portfolio::lang.components.industries.properties.industry_page.title',
                'description' => 'prismify.portfolio::lang.components.industries.properties.industry_page.description',
                'type'        => 'dropdown',
                'default'     => 'portfolio/industry',
                'group'       => 'prismify.portfolio::lang.components.industries.properties.industry_page.group',
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
        $this->industries = $this->page['industries'] = $this->loadIndustries();
    }

    /**
     * Load all industries or, depending on the <displayEmpty> option, only those that have projects
     * @return mixed
     */
    protected function loadIndustries()
    {
        if (!$this->property('displayEmpty')) {
            $industries = PortfolioIndustry::whereExists(function($query) {
                $prefix = Db::getTablePrefix();

                $query
                    ->select(Db::raw(1))
                    ->from('prismify_portfolio_projects_industries')
                    ->join('prismify_portfolio_projects', 'prismify_portfolio_projects.id', '=', 'prismify_portfolio_projects_industries.project_id')
                    ->whereNotNull('prismify_portfolio_projects.published')
                    ->where('prismify_portfolio_projects.published', '=', 1)
                    ->whereNotNull('prismify_portfolio_projects.published_at')
                    ->where('prismify_portfolio_projects.published_at', '<', Carbon::now())
                    ->whereRaw($prefix.'prismify_portfolio_industries.id = '.$prefix.'prismify_portfolio_projects_industries.industry_id')
                ;
            });

            $industries = $industries->get();
        }
        else {
            $industries = PortfolioIndustry::get();
        }

        /*
         * Add a "url" helper attribute for linking to each industry
         */
        return $this->linkIndustries($industries);
    }

    protected function linkIndustries($industries)
    {
        return $industries->each(function($industry) {
            $industry->setUrl($this->industryPage, $this->controller);
        });
    }
}
