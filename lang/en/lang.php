<?php

return [
    'details' => [
        'name' => 'Portfolio',
        'description' => 'Manage your industries that you support, projects, reviews or anything else.',
        'author' => 'Prismify'
    ],
    'permissions' => [
        'access_industries' => 'Manage portfolio industries',
        'access_projects' => 'Manage portfolio projects',
        'access_reviews' => 'Manage portfolio reviews',
    ],
    'navigation' => [
        'industries' => 'Industries',
        'projects' => 'Projects',
        'reviews' => 'Reviews',
    ],
    'components' => [
        'industries' => [
            'details' => [
                'name' => 'Industries',
                'description' => 'Displays a list of all industries on the page.'
            ],
            'properties' => [
                'slug' => [
                    'title' => 'Industry slug',
                    'description' => 'Look up the industry using the supplied slug value. This property is used by the default component partial for marking the currently active industry.'
                ],
                'display_empty' => [
                    'title' => 'Display empty industries',
                    'description' => 'Show industries that do not have any projects.'
                ],
                'industry_page' => [
                    'title' => 'Industry page',
                    'description' => 'Name of the industry page file for the industry links. This property is used by the default component partial.',
                    'group' => 'Links'
                ],
            ],
        ],
        'reviews' => [
            'details' => [
                'name' => 'Reviews',
                'description' => 'Displays a list of all reviews on the page.'
            ],
            'properties' => [
                'no_reviews' => [
                    'title' => 'No reviews message',
                    'description' => 'Message to display in the review list in case if there are no reviews. This property is used by the default component partial.'
                ],
                'order' => [
                    'title' => 'Sort order',
                    'description' => 'Attribute on which the reviews should be ordered'
                ],
            ]
        ],
        'project' => [
            'details' => [
                'name' => 'Project',
                'description' => 'Displays a project on the page.'
            ],
            'properties' => [
                'slug' => [
                    'title' => 'Project slug',
                    'description' => 'Look up the project using the supplied slug value.'
                ],
                'industry_page' => [
                    'title' => 'Industry page',
                    'description' => 'Name of the industry page file for the industry links. This property is used by the default component partial.',
                    'group' => 'Links'
                ],
            ],
        ],
        'projects' => [
            'details' => [
                'name' => 'Projects',
                'description' => 'Displays a list of latest projects on the page.'
            ],
            'properties' => [
                'page_number' => [
                    'title' => 'Page number',
                    'description' => 'This value is used to determine what page the user is on.'
                ],
                'filter' => [
                    'title' => 'Industry filter',
                    'description' => 'Enter a industry slug or URL parameter to filter the projects by. Leave empty to show all projects.'
                ],
                'per_page' => [
                    'title' => 'Projects per page',
                    'validation' => 'Invalid format of the projects per page value'
                ],
                'no_message' => [
                    'title' => 'No projects message',
                    'validation' => 'Message to display in the projects list in case if there are no projects. This property is used by the default component partial.'
                ],
                'sort_order' => [
                    'title' => 'Sort order',
                    'validation' => 'Attribute on which the projects should be ordered'
                ],
                'industry_page' => [
                    'title' => 'Industry page',
                    'description' => 'Name of the industry page file for the industry links. This property is used by the default component partial.',
                    'group' => 'Links'
                ],
                'project_page' => [
                    'title' => 'Project page',
                    'description' => 'Name of the portfolio project page file for the "Learn more" links. This property is used by the default component partial.',
                    'group' => 'Links'
                ],
            ],
        ]
    ],
    'controllers' => [
        'industries' => [
            'config' => [
                'form' => [
                    'name' => 'Industry',
                    'breadcrumb' => 'Industries',
                    'create' => [
                        'title' => 'Create Industry'
                    ],
                    'update' => [
                        'title' => 'Update Industry'
                    ],
                    'preview' => [
                        'title' => 'Preview Industry'
                    ],
                    'toolbar' => [
                        'buttons' => [
                            'cancel' => [
                                'title' => 'Cancel',
                            ],
                            'create' => [
                                'title' => 'Create',
                                'indicator' => 'Creating Industry...'
                            ],
                            'create&close' => [
                                'title' => 'Create and Close',
                                'indicator' => 'Creating Industry...'
                            ],
                            'save' => [
                                'title' => 'Save',
                                'indicator' => 'Saving Industry...'
                            ],
                            'save&close' => [
                                'title' => 'Save and Close',
                                'indicator' => 'Saving Industry...'
                            ],
                            'delete' => [
                                'confirm' => 'Delete this industry?',
                                'indicator' => 'Deleting Industry...'
                            ],
                            'return' => [
                                'title' => 'Return to industries list',
                            ],
                            'or' => [
                                'title' => 'or',
                            ]
                        ]
                    ],
                ],
                'list' => [
                    'title' => 'Manage Industries',
                    'toolbar' => [
                        'buttons' => [
                            'create' => [
                                'title' => 'New Industry'
                            ],
                            'delete' => [
                                'title' => 'Delete selected',
                                'confirm' => 'Are you sure you want to delete the selected Industries?'
                            ]
                        ]
                    ],
                ],
            ]
        ],
        'projects' => [
            'config' => [
                'form' => [
                    'name' => 'Project',
                    'breadcrumb' => 'Projects',
                    'create' => [
                        'title' => 'Create Project'
                    ],
                    'update' => [
                        'title' => 'Update Project'
                    ],
                    'preview' => [
                        'title' => 'Preview Project'
                    ],
                    'toolbar' => [
                        'buttons' => [
                            'cancel' => [
                                'title' => 'Cancel',
                            ],
                            'create' => [
                                'title' => 'Create',
                                'indicator' => 'Creating Project...'
                            ],
                            'create&close' => [
                                'title' => 'Create and Close',
                                'indicator' => 'Creating Project...'
                            ],
                            'save' => [
                                'title' => 'Save',
                                'indicator' => 'Saving Project...'
                            ],
                            'save&close' => [
                                'title' => 'Save and Close',
                                'indicator' => 'Saving Project...'
                            ],
                            'delete' => [
                                'confirm' => 'Delete this industry?',
                                'indicator' => 'Deleting Project...'
                            ],
                            'return' => [
                                'title' => 'Return to projects list',
                            ],
                            'or' => [
                                'title' => 'or',
                            ]
                        ]
                    ],
                ],
                'list' => [
                    'title' => 'Manage Projects',
                    'toolbar' => [
                        'buttons' => [
                            'create' => [
                                'title' => 'New Project'
                            ],
                            'delete' => [
                                'title' => 'Delete selected',
                                'confirm' => 'Are you sure you want to delete the selected Projects?'
                            ]
                        ]
                    ],
                ],
                'relation' => [
                    'reviews' => [
                        'label' => 'Reviews'
                    ],
                ]
            ]
        ],
        'reviews' => [
            'config' => [
                'form' => [
                    'name' => 'Review',
                    'breadcrumb' => 'Reviews',
                    'create' => [
                        'title' => 'Create Review'
                    ],
                    'update' => [
                        'title' => 'Update Review'
                    ],
                    'preview' => [
                        'title' => 'Preview Review'
                    ],
                    'toolbar' => [
                        'buttons' => [
                            'cancel' => [
                                'title' => 'Cancel',
                            ],
                            'create' => [
                                'title' => 'Create',
                                'indicator' => 'Creating Review...'
                            ],
                            'create&close' => [
                                'title' => 'Create and Close',
                                'indicator' => 'Creating Review...'
                            ],
                            'save' => [
                                'title' => 'Save',
                                'indicator' => 'Saving Review...'
                            ],
                            'save&close' => [
                                'title' => 'Save and Close',
                                'indicator' => 'Saving Review...'
                            ],
                            'delete' => [
                                'confirm' => 'Delete this industry?',
                                'indicator' => 'Deleting Review...'
                            ],
                            'return' => [
                                'title' => 'Return to reviews list',
                            ],
                            'or' => [
                                'title' => 'or',
                            ]
                        ]
                    ],
                ],
                'list' => [
                    'title' => 'Manage Reviews',
                    'toolbar' => [
                        'buttons' => [
                            'create' => [
                                'title' => 'New Review'
                            ],
                            'delete' => [
                                'title' => 'Delete selected',
                                'confirm' => 'Are you sure you want to delete the selected Reviews?'
                            ]
                        ]
                    ],
                ],
            ]
        ]
    ],
    'models' => [
        'all' => [
            'columns' => [
                'created_at' => [
                    'label' => 'Created'
                ],
                'updated_at' => [
                    'label' => 'Updated'
                ],
                'published_at' => [
                    'label' => 'Published'
                ],
            ],
            'fields' => [
                'tabs' => [
                    'meta' => 'Meta Tags'
                ],

                'meta_title' => [
                    'label' => 'Meta Title'
                ],
                'meta_description' => [
                    'label' => 'Meta Description'
                ],
                'meta_keywords' => [
                    'label' => 'Meta Keywords'
                ],

                'published' => [
                    'label' => 'Published',
                    'validation' => 'Please specify the published date'
                ],
                'published_at' => [
                    'label' => 'Published on'
                ],
            ]
        ],

        'industry' => [
            'columns' => [
                'name' => [
                    'label' => 'Name',
                ],
                'project_count' => [
                    'label' => 'Projects'
                ],
            ],
            'fields' => [
                'tabs' => [
                    'description' => 'Description'
                ],
                'name' => [
                    'label' => 'Name',
                    'placeholder' => 'New industry name'
                ],
                'slug' => [
                    'label' => 'Slug',
                    'placeholder' => 'new-industry-slug'
                ],
                'description' => [
                    'label' => 'Description',
                ],
                'thumbnail' => [
                    'label' => 'Thumbnail',
                ],
            ]
        ],

        'project' => [
            'columns' => [
                'title' => [
                    'label' => 'Title',
                ],
            ],
            'fields' => [
                'tabs' => [
                    'general' => 'General',
                    'description' => 'Description',
                    'industries' => 'Industries',
                    'reviews' => 'Reviews',
                ],
                'title' => [
                    'label' => 'Title',
                    'placeholder' => 'New project title'
                ],
                'slug' => [
                    'label' => 'Slug',
                    'placeholder' => 'new-project-slug'
                ],
                'excerpt' => [
                    'label' => 'Excerpt',
                ],
                'purpose' => [
                    'label' => 'Purpose',
                ],
                'process' => [
                    'label' => 'Process',
                ],
                'result' => [
                    'label' => 'Result',
                ],
                'industries' => [
                    'label' => 'Industries',
                    'commentAbove' => 'Select industries the project belongs to',
                    'placeholder' => 'There are no industries, you should create one first!'
                ],
                'reviews' => [
                    'label' => 'Reviews',
                    'comment' => 'Create or add reviews the project belongs to'
                ],
                'thumbnail' => [
                    'label' => 'Thumbnail',
                ],
                'featured_images' => [
                    'label' => 'Featured Images'
                ],
            ]
        ],

        'review' => [
            'columns' => [
                'author' => [
                    'label' => 'Author'
                ],
            ],
            'fields' => [
                'author_avatar' => [
                    'label' => 'Author Avatar'
                ],
                'author_name' => [
                    'label' => 'Author Name'
                ],
                'author_position' => [
                    'label' => 'Author Position'
                ],
                'title' => [
                    'label' => 'Title'
                ],
                'blockquote' => [
                    'label' => 'Blockquote'
                ]
            ]
        ],
    ],
];