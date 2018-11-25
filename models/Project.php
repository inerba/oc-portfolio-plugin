<?php namespace Prismify\Portfolio\Models;

use Db;
use Str;
use Lang;
use Model;
use ValidationException;
use Carbon\Carbon;
use Cms\Classes\Page as CmsPage;

/**
 * Project Model
 */
class Project extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'prismify_portfolio_projects';
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $rules = [
        'title' => 'required',
        'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:prismify_portfolio_projects'],
        'excerpt' => '',
        'meta_description' => 'max:155',
        'meta_keywords' => '',
        'meta_title' => 'max:70'
    ];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = [
        'title',
        'excerpt',
        ['slug', 'index' => true],
        'meta_description',
        'meta_keywords',
        'meta_title'
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * The attributes on which the project list can be ordered
     * @var array
     */
    public static $allowedSortingOptions = [
        'title asc' => 'Title (ascending)',
        'title desc' => 'Title (descending)',
        'created_at asc' => 'Created (ascending)',
        'created_at desc' => 'Created (descending)',
        'updated_at asc' => 'Updated (ascending)',
        'updated_at desc' => 'Updated (descending)',
        'published_at asc' => 'Published (ascending)',
        'published_at desc' => 'Published (descending)',
        'random' => 'Random'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'industries' => [
            'Prismify\Portfolio\Models\Industry',
            'table' => 'prismify_portfolio_projects_industries',
            'order' => 'name'
        ],
        'reviews' => [
            'Prismify\Portfolio\Models\Review',
            'table' => 'prismify_portfolio_projects_reviews',
            'order' => 'author_name'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'thumbnail' => [
            'System\Models\File',
        ]
    ];
    public $attachMany = [
        'featured_images' => [
            'System\Models\File',
            'order' => 'sort_order'
        ],
    ];

    public function afterValidate()
    {
        if ($this->published && !$this->published_at) {
            throw new ValidationException([
                'published_at' => Lang::get('prismify.portfolio::lang.models.all.fields.published.validation')
            ]);
        }
    }

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->slug,
        ];

        if (array_key_exists('industries', $this->getRelations())) {
            $params['industriy'] = $this->industries->count() ? $this->industries->first()->slug : null;
        }

        // expose published year, month and day as URL parameters
        if ($this->published) {
            $params['year'] = $this->published_at->format('Y');
            $params['month'] = $this->published_at->format('m');
            $params['day'] = $this->published_at->format('d');
        }

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    //
    // Scopes
    //

    public function scopeIsPublished($query)
    {
        return $query
            ->whereNotNull('published')
            ->where('published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<', Carbon::now())
            ;
    }

    /**
     * Lists projects for the front end
     *
     * @param        $query
     * @param  array $options Display options
     *
     * @return Project
     */
    public function scopeListFrontEnd($query, $options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page'       => 1,
            'perPage'    => 30,
            'sort'       => 'created_at',
            'industries' => null,
            'industry'   => null,
            'search'     => '',
            'published'  => true,
        ], $options));

        $searchableFields = ['title', 'slug', 'excerpt'];

        if ($published) {
            $query->isPublished();
        }

        /*
         * Sorting
         */
        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {

            if (in_array($_sort, array_keys(self::$allowedSortingOptions))) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                if ($sortField == 'random') {
                    $sortField = Db::raw('RAND()');
                }
                $query->orderBy($sortField, $sortDirection);
            }
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $query->searchWhere($search, $searchableFields);
        }

        /*
         * Industries
         */
        if ($industries !== null) {
            if (!is_array($industries)) $industries = [$industries];
            $query->whereHas('industries', function($q) use ($industries) {
                $q->whereIn('id', $industries);
            });
        }

        return $query->paginate($perPage, $page);
    }

    /**
     * Allows filtering for specifc industries
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $industries List of industry ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterIndustries($query, $industries)
    {
        return $query->whereHas('industries', function($q) use ($industries) {
            $q->whereIn('id', $industries);
        });
    }

    /**
     * Returns URL of a project page.
     *
     * @param $pageCode
     * @param $industry
     * @param $theme
     */
    protected static function getPostPageUrl($pageCode, $industry, $theme)
    {
        $page = CmsPage::loadCached($theme, $pageCode);
        if (!$page) return;

        $properties = $page->getComponentProperties('portfolioProject');
        if (!isset($properties['slug'])) {
            return;
        }

        /*
         * Extract the routing parameter name from the industry filter
         * eg: {{ :someRouteParam }}
         */
        if (!preg_match('/^\{\{([^\}]+)\}\}$/', $properties['slug'], $matches)) {
            return;
        }

        $paramName = substr(trim($matches[1]), 1);
        $params = [
            $paramName => $industry->slug,
            'year' => $industry->published_at->format('Y'),
            'month' => $industry->published_at->format('m'),
            'day' => $industry->published_at->format('d'),
        ];
        $url = CmsPage::url($page->getBaseFileName(), $params);

        return $url;
    }
}
