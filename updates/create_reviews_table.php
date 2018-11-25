<?php namespace Prismify\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('prismify_portfolio_reviews', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title')->nullable();
            $table->text('blockquote')->nullable();
            $table->text('author_name')->nullable();
            $table->text('author_position')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('prismify_portfolio_projects_reviews', function($table) {
            $table->engine = 'InnoDB';
            $table->integer('project_id')->unsigned();
            $table->integer('review_id')->unsigned();
            $table->primary(['project_id', 'review_id'], 'project_review');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prismify_portfolio_reviews');
        Schema::dropIfExists('prismify_portfolio_projects_reviews');
    }
}
