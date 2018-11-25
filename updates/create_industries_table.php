<?php namespace Prismify\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIndustriesTable extends Migration
{
    public function up()
    {
        Schema::create('prismify_portfolio_industries', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->index();
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_title')->nullable();
            $table->timestamps();
        });

        Schema::create('prismify_portfolio_projects_industries', function($table) {
            $table->engine = 'InnoDB';
            $table->integer('project_id')->unsigned();
            $table->integer('industry_id')->unsigned();
            $table->primary(['project_id', 'industry_id'], 'project_industry');
        });

    }

    public function down()
    {
        Schema::dropIfExists('prismify_portfolio_industries');
        Schema::dropIfExists('prismify_portfolio_projects_industries');
    }
}
