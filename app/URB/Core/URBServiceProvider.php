<?php namespace URB\Core;

use Illuminate\Support\ServiceProvider;
use URB\Posts\Posts;
use URB\Posts\PostsRepository;
use URB\Items\Items;
use URB\Items\ItemsRepository;

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

        // Bind Items Repository to IoC 
        $this->app->bind('ItemsRepository', function($app)
        {
            return new ItemsRepository(new Items());
        });
    }
}