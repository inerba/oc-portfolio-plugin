<?php namespace Prismify\Portfolio\Components;

use Cms\Classes\ComponentBase;
use Prismify\Portfolio\Models\Review as PortfolioReview;

class Reviews extends ComponentBase
{
    /**
     * A collection of reviews to display
     * @var Collection
     */
    public $reviews;

    /**
     * Message to display when there are no messages.
     * @var string
     */
    public $noReviewsMessage;

    /**
     * If the review list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    public function componentDetails()
    {
        return [
            'name'        => 'prismify.portfolio::lang.components.reviews.details.name',
            'description' => 'prismify.portfolio::lang.components.reviews.details.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'noReviewsMessage' => [
                'title' => 'prismify.portfolio::lang.components.reviews.properties.no_reviews.title',
                'description' => 'prismify.portfolio::lang.components.reviews.properties.no_reviews.description',
                'type' => 'string',
                'default' => 'No reviews found',
                'showExternalParam' => false
            ],
            'sortOrder' => [
                'title' => 'prismify.portfolio::lang.components.reviews.properties.order.title',
                'description' => 'prismify.portfolio::lang.components.reviews.properties.order.description',
                'type' => 'dropdown',
                'default' => 'published_at desc'
            ],
        ];
    }

    public function getSortOrderOptions()
    {
        return PortfolioReview::$allowedSortingOptions;
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->reviews = $this->page['reviews'] = $this->listReviews();
    }

    protected function prepareVars()
    {
        $this->noReviewsMessage = $this->page['noReviewsMessage'] = $this->property('noReviewsMessage');
    }

    protected function listReviews()
    {
        /*
         * List all the reviews
         */

        $reviews = PortfolioReview::isPublished()->listFrontEnd([
            'sort'       => $this->property('sortOrder'),
            'search'     => trim(input('search'))
        ]);

        $reviews = $reviews->get();

        return $reviews;
    }
}
