<?php namespace Prismify\Portfolio;

use Backend;
use System\Classes\PluginBase;

/**
 * Portfolio Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'prismify.portfolio::lang.details.name',
            'description' => 'prismify.portfolio::lang.details.description',
            'author'      => 'prismify.portfolio::lang.details.author',
            'icon'        => 'icon-pencil',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Prismify\Portfolio\Components\Industries'  => 'portfolioIndustries',
            'Prismify\Portfolio\Components\Project'     => 'portfolioProject',
            'Prismify\Portfolio\Components\Projects'    => 'portfolioProjects',
            'Prismify\Portfolio\Components\Reviews'     => 'portfolioReviews',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'prismify.portfolio.access_industries' => [
                'tab' => 'prismify.portfolio::lang.details.name',
                'label' => 'prismify.portfolio::lang.permissions.access_industries'
            ],
            'prismify.portfolio.access_projects' => [
                'tab' => 'prismify.portfolio::lang.details.name',
                'label' => 'prismify.portfolio::lang.permissions.access_projects'
            ],
            'prismify.portfolio.access_reviews' => [
                'tab' => 'prismify.portfolio::lang.details.name',
                'label' => 'prismify.portfolio::lang.permissions.access_reviews'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'portfolio' => [
                'label'       => 'prismify.portfolio::lang.details.name',
                'url'         => Backend::url('prismify/portfolio/industries'),
                'icon'        => 'icon-pencil',
                'iconSvg'     => 'plugins/prismify/portfolio/assets/images/portfolio-icon.svg',
                'permissions' => ['prismify.portfolio.access_industries'],
                'order'       => 500,

                'sideMenu' => [
                    'industries' => [
                        'label'       => 'prismify.portfolio::lang.navigation.industries',
                        'icon'        => 'icon-server',
                        'url'         => Backend::url('prismify/portfolio/industries'),
                        'permissions' => ['prismify.portfolio.access_industries']
                    ],
                    'projects' => [
                        'label'       => 'prismify.portfolio::lang.navigation.projects',
                        'icon'        => 'icon-diamond',
                        'url'         => Backend::url('prismify/portfolio/projects'),
                        'permissions' => ['prismify.portfolio.access_projects']
                    ],
                    'reviews' => [
                        'label'       => 'prismify.portfolio::lang.navigation.reviews',
                        'icon'        => 'icon-comment-o',
                        'url'         => Backend::url('prismify/portfolio/reviews'),
                        'permissions' => ['prismify.portfolio.access_reviews']
                    ],
                ],
            ],
        ];
    }
}
