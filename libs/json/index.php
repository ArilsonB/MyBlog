

    $rules = array( 
        'picture'   => "/picture/(?'picture'[^/]+)",    // '/picture/some-text/51'
        'album'     => "/album/(?'album'[\w\-]+)",              // '/album/album-slug'
        'category'  => "/category/(?'category'[\w\-]+)",        // '/category/category-slug'
        'dash'      => "/(?'dash'login|register)",
        'page'      => "/(?'page'[^/]+)",     //(?'page'about|contact)     // '/page/about', '/page/contact'
        'post'      => "/(?'year'[0-9]{4}+)/(?'month'[0-9]{2}+)/(?'postname'[\w\-]+).html",                     // '/post-slug'
        'home'      => "/"                                      // '/'
    );

    $rules = @file_get_contents(dirname(__FILE__) . '/../json/friendly_url.json');
    $rules = json_decode($rules, true);
    $rules = $rules['friendly_urls'];