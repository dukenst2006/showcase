<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['domain' => 'laravel.dev', function () {
    return view('welcome');
}])->name('index');

Route::match(['get', 'post'], '/about', ['domain' => 'laravel.dev', function () {
    return "Welcome to laravel 5.3 sandbox";
}])->name('page.about');

Route::get('/explore', [
    'as' => 'page.explore',
    'uses' => 'PageController@explore'
]);

Route::get('/help', [
    'as' => 'page.help',
    'uses' => 'PageController@help'
]);

Route::group(['domain' => 'admin.laravel.dev', 'namespace' => 'Admin'], function () {
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    Route::get('/', function () {
        return redirect('dashboard');
    })->middleware('auth:admin');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('dashboard', [
            'as' => 'admin.dashboard',
            'uses' => 'DashboardController',
            'middleware' => 'auth:admin'
        ]);

        Route::resource('user', 'UserController', [
            'names' => [
                'index' => 'admin.user',
                'create' => 'admin.user.create',
                'store' => 'admin.user.store',
                'edit' => 'admin.user.edit',
                'update' => 'admin.user.update',
                'show' => 'admin.user.show',
                'destroy' => 'admin.user.destroy'
            ]
        ]);

        Route::resource('portfolio', 'PortfolioController', [
            'names' => [
                'index' => 'admin.portfolio',
                'create' => 'admin.portfolio.create',
                'store' => 'admin.portfolio.store',
                'edit' => 'admin.portfolio.edit',
                'update' => 'admin.portfolio.update',
                'show' => 'admin.portfolio.show',
                'destroy' => 'admin.portfolio.destroy'
            ]
        ]);

        Route::resource('tag', 'TagController', [
            'only' => ['index', 'store', 'destroy'],
            'parameters' => [
                'tag' => 'id'
            ],
            'names' => [
                'index' => 'admin.tag',
                'store' => 'admin.tag.store',
                'destroy' => 'admin.tag.destroy'
            ]
        ]);

        Route::resource('category', 'CategoryController', [
            'except' => ['show', 'create', 'edit', 'update'],
            'names' => [
                'index' => 'admin.category',
                'store' => 'admin.category.store',
                'destroy' => 'admin.category.destroy'
            ]
        ]);

        Route::get('report', [
            'as' => 'admin.report',
            'uses' => 'ReportController@index'
        ]);

        Route::any('contact', [
            'as' => 'admin.contact',
            'uses' => 'ContactController'
        ]);
    });
});

Route::group(['domain' => 'account.laravel.dev'], function () {
    // Auth::routes();

    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('account.login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('account.logout');

    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('account.register');
    $this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');

    // Activation Route...
    Route::get('/activation/{token}', 'Auth\RegisterController@userActivation');

    // After Login Route...
    Route::get('/', [
        'as' => 'account.profile',
        'uses' => 'UserController@index'
    ]);
});

Route::group(['domain' => 'account.laravel.dev', 'prefix' => '{user}'], function () {
    Route::get('/', [
        'as' => 'account.profile.show',
        'uses' => 'UserController@show'
    ]);

    Route::get('/portfolio', [
        'as' => 'account.profile.portfolio',
        'uses' => 'UserController@portfolio'
    ]);

    Route::get('/settings', [
        'as' => 'account.profile.settings',
        'uses' => 'UserController@settings'
    ]);
});

Route::group(['domain' => 'laravel.dev', 'prefix' => '{user}'], function () {
    Route::get('/', [
        'as' => 'profile.show',
        'uses' => 'PageController@show'
    ]);

    Route::get('/portfolio', [
        'as' => 'profile.portfolio',
        'uses' => 'PageController@portfolio'
    ]);

    Route::get('/about', [
        'as' => 'profile.about',
        'uses' => 'PageController@about'
    ]);

    Route::get('/contact', [
        'as' => 'profile.contact',
        'uses' => 'PageController@contact'
    ]);
});

