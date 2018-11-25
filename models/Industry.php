<?php namespace Prismify\Portfolio\Models;

use Model;

/**
 * Industry Model
 */
class Industry extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'prismify_portfolio_industries';
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var array Validation fields
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|between:2,64|unique:prismify_portfolio_industries',
        'description' => '',
        'meta_description' => 'max:155',
        'meta_keywords' => '',
        'meta_title' => 'max:70'
    ];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = [
        'name',
        ['slug', 'index' => true],
        'description',
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
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'projects' => [
            'Prismify\Portfolio\Models\Project',
            'table' => 'prismify_portfolio_projects_industries',
            'order' => 'published_at desc',
            'scope' => 'isPublished'
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'thumbnail' => 'System\Models\File'
    ];
    public $attachMany = [];

    public function afterDelete()
    {
        $this->projects()->detach();
    }

    public function getProjectCountAttribute()
    {
        return $this->projects()->count();
    }
}
