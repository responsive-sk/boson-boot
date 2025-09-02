<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Blog Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration specific to the blog functionality of the application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Articles Per Page
    |--------------------------------------------------------------------------
    |
    | This value determines how many articles are displayed per page in the
    | blog listing. You may change this value to suit your needs.
    |
    */

    'articles_per_page' => env('ARTICLES_PER_PAGE', 10),

    /*
    |--------------------------------------------------------------------------
    | Blog Excerpt Length
    |--------------------------------------------------------------------------
    |
    | This value determines the maximum length of article excerpts in characters.
    | If an article doesn't have a custom excerpt, this will be used to
    | generate one from the content.
    |
    */

    'excerpt_length' => env('BLOG_EXCERPT_LENGTH', 150),

    /*
    |--------------------------------------------------------------------------
    | Featured Image Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for article featured images.
    |
    */

    'featured_image' => [
        'width' => 800,
        'height' => 400,
        'quality' => 85,
    ],

    /*
    |--------------------------------------------------------------------------
    | Search Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the blog search functionality.
    |
    */

    'search' => [
        'min_length' => env('SEARCH_MIN_LENGTH', 2),
        'max_results' => env('SEARCH_MAX_RESULTS', 50),
    ],

    /*
    |--------------------------------------------------------------------------
    | Comment Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for article comments (if enabled in the future).
    |
    */

    'comments' => [
        'enabled' => false,
        'moderation' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | RSS Feed Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for RSS feed generation.
    |
    */

    'rss' => [
        'enabled' => true,
        'items' => 20,
        'title' => 'Boson PHP Blog',
        'description' => 'Latest articles from Boson PHP',
    ],
];
