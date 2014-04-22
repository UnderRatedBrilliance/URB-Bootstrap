<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	$posts = App::make('PostsRepository')->model->select(\DB::raw('
				YEAR(`published_date`) AS `year`,
				DATE_FORMAT(`published_date`, "%m") AS `month`,
				MONTHNAME(`published_date`) AS `monthname`,
				COUNT(*) AS `count`
			'))
			->groupBy(\DB::raw('DATE_FORMAT(`published_date`, "%Y%m")'))
			->orderBy('published_date', 'desc')
			->get();

	return $posts->toJson();
});

Route::get('/testData', function()
{
	$posts = App::make('PostsRepository');

	$lipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas id neque a nunc gravida elementum. Donec eu venenatis lacus, id tempus nunc. Vivamus eleifend vestibulum mauris, eget pretium lectus interdum ac. Proin aliquam nibh turpis. Nunc dui erat, tristique mattis nibh nec, auctor adipiscing erat. Morbi hendrerit ligula ut nisl porttitor, at convallis dui molestie. Ut in tempus sapien, nec fermentum lacus. Nullam lacinia posuere massa. Quisque in tortor orci. Praesent laoreet pulvinar tempus.

Praesent bibendum eget dolor a dapibus. Suspendisse dignissim odio vel rutrum bibendum. Nam faucibus venenatis sapien, ut tincidunt ante ullamcorper sit amet. Nullam quis dolor ac enim consectetur pellentesque. Fusce adipiscing sapien quis mauris accumsan, accumsan blandit augue ultrices. Mauris sit amet dolor eleifend, ultricies orci sit amet, viverra magna. Morbi vitae massa vel nibh iaculis fermentum. Maecenas et metus pulvinar, porta orci eget, lacinia odio. Donec id magna erat. Vestibulum eleifend elementum metus quis faucibus.

Vestibulum in lacinia tortor. Suspendisse accumsan risus a arcu ultrices, quis ultricies sapien auctor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vivamus at aliquet neque. Praesent porttitor nisl ligula, eget rutrum sapien fermentum vitae. Curabitur blandit urna non facilisis fringilla. Mauris et aliquet ipsum, vehicula hendrerit neque. Ut in erat nisi. Nam feugiat pulvinar ante, non pretium leo gravida eget. Donec quis urna ut neque molestie fringilla vel ac arcu. Cras scelerisque risus eu lacus lacinia, ut aliquam augue lobortis.

Fusce tincidunt, lacus tempor sollicitudin faucibus, est odio condimentum turpis, nec dignissim sapien nunc sodales sem. Curabitur rhoncus, erat blandit pretium tincidunt, neque leo vehicula leo, eu aliquam arcu quam elementum nibh. Phasellus sit amet magna id lorem malesuada blandit eget vitae leo. Donec et purus libero. Quisque ut quam ac massa vehicula tincidunt. Etiam at cursus urna. Mauris vel metus vitae velit ultricies vestibulum id ac massa. Sed iaculis purus odio. Fusce dapibus vestibulum tortor, condimentum dignissim lorem pellentesque sit amet. Suspendisse blandit est vel mi egestas, sed accumsan ante adipiscing. Duis fringilla libero ut enim sollicitudin, sit amet convallis turpis euismod.

In posuere nulla eget varius fermentum. Nam ac laoreet dolor. Donec dignissim at erat vel commodo. Etiam accumsan aliquet pharetra. Donec vel felis a dui pharetra dignissim nec vitae nulla. Suspendisse ipsum nibh, pulvinar non dolor eu, bibendum volutpat sem. In purus risus, vehicula ut pharetra ut, venenatis sed mauris. Suspendisse id faucibus mauris. Duis eleifend placerat eros ut tincidunt. Vestibulum ultricies rutrum augue ut posuere. Nunc sollicitudin, metus ullamcorper tempor mollis, quam dui consectetur orci, eu pellentesque orci erat nec diam. Pellentesque interdum vitae massa non sagittis. Vestibulum bibendum erat mi, sed elementum tortor facilisis et.";


	for($i = 1; $i < 500; $i++) 
	{
		$newPost = $posts->getNew();
		$newPost->title = 'Filler Sample Posts '. $i;
		$newPost->content = 'New Sample Content '. $i .' '.$lipsum;
		$newPost->excerpt = 'Sample Exerpt Conenent '. $i;
		$newPost->status = 1;
		$newPost->meta_title = $newPost->title;
		$newPost->meta_description = substr($newPost->content,0,255);
		$newPost->meta_keywords = 'Sample Keywords '. $i;
		$newPost->last_edited_by = 1;
		$newPost->user_id = 1;
		$newPost->published_date = \Carbon\Carbon::now()->subDays(rand(15,400));
	//var_dump($newPost);
		$posts->save($newPost);
	}
	

	

	$posts = $posts->getAllPaginated();
	return $posts->toJson();
});

Route::get('/{slug?}', array('as'=>'slug',function($slug)
{
	
	$posts = App::make('PostsRepository')->find(3);	

	return $posts->toJson();
}));