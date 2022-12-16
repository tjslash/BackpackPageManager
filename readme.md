# Cto CRUD Page Manager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![The Whole Fruit Manifesto](https://img.shields.io/badge/writing%20standard-the%20whole%20fruit-brightgreen)](https://github.com/the-whole-fruit/manifesto)

This package Page CRUD Manager functionality for projects that use the [Backpack for Laravel](https://backpackforlaravel.com/) administration panel. 

## Screenshots

![screencapture-127-0-0-1-8000-admin-page-2022-12-16-08_36_17](https://user-images.githubusercontent.com/569999/207989280-c6d7546e-c8ca-4729-875c-95318b777372.png)
![screencapture-127-0-0-1-8000-admin-page-2-edit-2022-12-16-08_36_30](https://user-images.githubusercontent.com/569999/207989290-d5236b87-e007-4223-b443-c378cbf1f8c4.png)
![screencapture-127-0-0-1-8000-admin-page-2-edit-2022-12-16-08_37_00](https://user-images.githubusercontent.com/569999/207989293-8981a882-3caf-44ba-bac4-3349ee4befb7.png)


## Installation

Composer:

``` bash
composer require tjslash/cto-page-manager
```

Put link for administration sidebar:

``` bash
php artisan backpack:add-sidebar-content "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon la la-question'></i> {{ __('tjslash::cto-page-manager.pages') }}</a></li>"
```

Put web route for show a pages:

``` php
use \Tjslash\CtoPageManager\Http\Controllers\PageController;

Route::get('{page}', [PageController::class, 'index'])->name('page');
```


## Usage

> Page CRUD Manager done! Use it simple.

Open Page CRUD Manager at the administration panel: 

[http://127.0.0.1:8000/admin/page](http://127.0.0.1:8000/admin/page)


## Configuration

#### Custom templates

You can use custom templates for view page.

Create views in resources:

``` bash
mkdir resources/views/page

touch resources/views/page/about-us.blade.php
```

Edit the configuration file (config/cto-page-manager.php)

``` php
...
    'views' => [
        'page.about' => 'About us',
    ],
...
```

Create/edit a page at the administration panel and set template for page.


## Change log

Changes are documented here on Github. Please see the [Releases tab](https://github.com/tjslash/cto-page-manager/releases).

## Testing

``` bash
composer test
```

## Contributing

Please see [contributing.md](contributing.md) for a todolist and howtos.

## Security

If you discover any security related issues, please email vakylenkox@gmail.com instead of using the issue tracker.

## Credits

- [Artem Vakylenko][link-author]
- [All Contributors][link-contributors]

## License

This project was released under MIT, so you can install it on top of any Backpack & Laravel project. Please see the [license file](license.md) for more information. 

However, please note that you do need Backpack installed, so you need to also abide by its [YUMMY License](https://github.com/Laravel-Backpack/CRUD/blob/master/LICENSE.md). That means in production you'll need a Backpack license code. You can get a free one for non-commercial use (or a paid one for commercial use) on [backpackforlaravel.com](https://backpackforlaravel.com).


[ico-version]: https://img.shields.io/packagist/v/tjslash/cto-page-manager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tjslash/cto-page-manager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/tjslash/cto-page-manager
[link-downloads]: https://packagist.org/packages/tjslash/cto-page-manager
[link-author]: https://github.com/tj
[link-contributors]: ../../contributors
