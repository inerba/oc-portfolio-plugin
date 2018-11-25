# Portfolio Plugin

Manage your industries that you support, projects, reviews or anything else.

## Implementing front-end pages
### Project list page

Use the `portfolioProjects` component to display a list of latest projects on a page. The component has the following properties:

* **pageNumber** - this value is used to determine what page the user is on, it should be a routing parameter for the default markup. The default value is **{{ :page }}** to obtain the value from the route parameter `:page`.
* **industryFilter** - a industry slug to filter the projects by. If left blank, all projects are displayed.
* **projectsPerPage** - how many projects to display on a single page (the pagination is supported automatically). The default value is 10.
* **noProjectsMessage** - message to display in the empty project list.
* **sortOrder** - the column name and direction used for the sort order of the projects. The default value is **published_at desc**.
* **industryPage** - path to the industry page. The default value is **portfolio/industry** - it matches the pages/portfolio/industry.htm file in the theme directory. This property is used in the default component partial for creating links to the portfolio industries.
* **projectPage** - path to the project details page. The default value is **portfolio/project** - it matches the pages/portfolio/project.htm file in the theme directory. This property is used in the default component partial for creating links to the portfolio projects.

The portfolioProjects component injects the following variables to the page where it's used:

* **projects** - a list of blog projects loaded from the database.
* **projectPage** - contains the value of the `projectPage` component's property.
* **industry** - the blog industry object loaded from the database. If the industry is not found, the variable value is **null**.
* **industryPage** - contains the value of the `industryPage` component's property.
* **noProjectsMessage** - contains the value of the `noProjectsMessage` component's property.

The component supports pagination and reads the current page index from the `:page` URL parameter. The next example shows the basic component usage on the portfolio home page:

    title = "Portfolio"
    url = "/portfolio/:page?"

    [portfolioProjects]
    projectsPerPage = "9"
    ==
    {% component 'portfolioProjects' %}

The next example shows the basic component usage with the industry filter:

    title = "Portfolio Industry"
    url = "/portfolio/industry/:slug/:page?"

    [portfolioProjects]
    industryFilter = "{{ :slug }}"
    ==
    function onEnd()
    {
        if ($this->industry)
            $this->page->title = $this->industry->name;
            // $this->page->meta_description = $this->industry->meta_description;
            // $this->page->meta_keywords = $this->industry->meta_keywords;
            // $this->page->meta_title = $this->industry->meta_title;
    }
    ==
    {% if not industry %}
        <h2>Industry not found</h2>
    {% else %}
        <h2>{{ industry.name }}</h2>

        {% component 'portfolioProjects' %}
    {% endif %}

The project list and the pagination are coded in the default component partial `plugins/prismify/portfolio/components/projects/default.htm`. If the default markup is not suitable for your website, feel free to copy it from the default partial and replace the `{% component %}` call in the example above with the partial contents.

### Project page

Use the `portfolioProject` component to display a portfolio project on a page. The component has the following properties:

* **slug** - the value used for looking up the project by its slug. The default value is **{{ :slug }}** to obtain the value from the route parameter `:slug`.
* **industryPage** - path to the industry page. The default value is **portfolio/industry** - it matches the pages/portfolio/industry.htm file in the theme directory. This property is used in the default component partial for creating links to the portfolio industries.

The component injects the following variables to the page where it's used:

* **project** - the portfolio project object loaded from the database. If the project is not found, the variable value is **null**.

The next example shows the basic component usage on the portfolio page:

    title = "Portfolio Project"
    url = "/portfolio/project/:slug"

    [portfolioProject]
    ==
    <?php
    function onEnd()
    {
        // Optional - set the page title to the project title
        if (isset($this->project))
            $this->page->title = $this->project->title;
            // $this->page->meta_description = $this->project->meta_description;
            // $this->page->meta_keywords = $this->project->meta_keywords;
            // $this->page->meta_title = $this->project->meta_title;
    }
    ?>
    ==
    {% if project %}
        <h2>{{ project.title }}</h2>

        {% component 'portfolioProject' %}
    {% else %}
        <h2>Project not found</h2>
    {% endif %}

The project details is coded in the default component partial `plugins/prismify/portfolio/components/project/default.htm`.

### Industry list

Use the `portfolioIndustries` component to display a list of portfolio project industries with links. The component has the following properties:

* **slug** - the value used for looking up the current industry by its slug. The default value is **{{ :slug }}** to obtain the value from the route parameter `:slug`.
* **displayEmpty** - determines if empty industries should be displayed. The default value is false.
* **industryPage** - path to the industry page. The default value is **portfolio/industry** - it matches the pages/portfolio/industry.htm file in the theme directory. This property is used in the default component partial for creating links to the portfolio industries.

The component injects the following variables to the page where it's used:

* **industryPage** - contains the value of the `industryPage` component's property. 
* **industries** - a list of portfolio industries loaded from the database.
* **currentIndustrySlug** - slug of the current industry. This property is used for marking the current industry in the industry list.

The component can be used on any page. The next example shows the basic component usage on the portfolio home page:

    title = "Portfolio"
    url = "/portfolio/:page?"

    [portfolioIndustries]
    ==
    ...
    <div class="sidebar">
        {% component 'portfolioIndustries' %}
    </div>
    ...

The industry list is coded in the default component partial `plugins/prismify/portfolio/components/industries/default.htm`.

### Review list

Use the `portfolioReviews` component to display a list of portfolio reviews on a page. The component has the following properties:

* **noReviewsMessage** - message to display in the empty review list.
* **sortOrder** - the column name and direction used for the sort order of the reviews. The default value is **published_at desc**.

The portfolioReviews component injects the following variables to the page where it's used:

* **noReviewsMessage** - contains the value of the `noReviewsMessage` component's property.


The component can be used on any page. The next example shows the basic component usage on the portfolio home page:

    title = "Portfolio"
    url = "/portfolio/:page?"
    
    [portfolioProjects]
    noReviewsMessage = "No reviews found"
    sortOrder = "published_at desc"
    ==
    
    {% component 'portfolioReviews' %}

The review list is coded in the default component partial `plugins/prismify/portfolio/components/reviews/default.htm`.

