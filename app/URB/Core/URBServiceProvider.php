<?php namespace URB\Core;

use Illuminate\Support\ServiceProvider;
use URB\Posts\Posts;
use URB\Posts\PostsRepository;


/**
* Register our Repository with Laravel
*/
class URBServiceProvider extends ServiceProvider 
{
    
    public function register()
    {
        // Bind Posts Repository to IoC 
        $this->app->bind('PostsRepository', function($app)
        {
            return new PostsRepository(new Posts());
        });
    }
}