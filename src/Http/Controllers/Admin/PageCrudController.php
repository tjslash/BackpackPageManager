<?php

namespace Tjslash\BackpackPageManager\Http\Controllers\Admin;

use Tjslash\BackpackPageManager\Http\Requests\PageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Tjslash\BackpackPageManager\Models\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Translation\Translator;

/**
 * Class PageCrudController
 * @package Tjslash\BackpackPageManager\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Page::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/page');
        CRUD::setEntityNameStrings(
            trans('tjslash::backpack-page-manager.page'), 
            trans('tjslash::backpack-page-manager.pages')
        );
        CRUD::denyAccess('show');
        CRUD::disableDetailsRow();
        if (backpack_pro()) {
            CRUD::enableExportButtons();
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'id',
            'label' => 'ID'
        ]);

        CRUD::addColumn([
            'name'     => 'title',
            'label'    => trans('tjslash::backpack-page-manager.title'),
        ]);

        CRUD::addColumn([
            'name' => 'slug',
            'label' => trans('tjslash::backpack-page-manager.slug'),
            'type'     => 'closure',
            'function' => function(Page $page) {
                if (!backpack_pro()) return $page->slug;
                return '<a target="_blank" href="' . $page->url . '">' . $page->slug . '</a>';
            },
            'searchLogic' => function (Builder $query, array $column, string $searchTerm) {
                return $query->orWhere('slug', 'like', "%{$searchTerm}%");
            }
        ]);

        if (count(config('tjslash.backpack-page-manager.views'))) {
            CRUD::addColumn([
                'name' => 'view',
                'label' => trans('tjslash::backpack-page-manager.template'),
                'type' => 'select_from_array',
                'options' => config('tjslash.backpack-page-manager.views')
            ]);
        }

        CRUD::addColumn([
            'type' => 'check',
            'name' => 'active',
            'label' => trans('tjslash::backpack-page-manager.active')
        ]);

        if (backpack_pro()) {
            $this->setupFilters();
        }
    }


    /**
     * Set filters
     * 
     * @see https://backpackforlaravel.com/docs/4.1/crud-filters
     * @return void
     */
    protected function setupFilters()
    {
        CRUD::addFilter([
                'type' => 'text',
                'name' => 'title',
                'label'=> trans('tjslash::backpack-page-manager.title')
            ], 
            false, 
            fn($value) => CRUD::addClause('where', 'title', 'LIKE', "%$value%")
        );

        CRUD::addFilter([
                'type' => 'text',
                'name' => 'slug',
                'label'=> trans('tjslash::backpack-page-manager.slug')
            ], 
            false, 
            fn($value) => CRUD::addClause('where', 'slug', 'LIKE', "%$value%")
        );

        if (count(config('tjslash.backpack-page-manager.views'))) {
            CRUD::addFilter([
                    'name' => 'view',
                    'type' => 'dropdown',
                    'label'=> trans('tjslash::backpack-page-manager.template')
                ],
                config('tjslash.backpack-page-manager.views'), 
                fn($value) => CRUD::addClause('where', 'view', $value)
            );
        }

        CRUD::addFilter([
                'name' => 'active',
                'type' => 'dropdown',
                'label'=> trans('tjslash::backpack-page-manager.active')
            ], [
                0 => 'Нет',
                1 => 'Да',
            ], fn($value) => CRUD::addClause('where', 'active', $value)
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PageRequest::class);

        CRUD::addField([
            'name' => 'title',
            'label' => trans('tjslash::backpack-page-manager.title'),
            'tab' => trans('tjslash::backpack-page-manager.common_settings')
        ]); 

        CRUD::addField([
            'name' => 'slug',
            'label' => trans('tjslash::backpack-page-manager.slug'),
            'tab' => trans('tjslash::backpack-page-manager.common_settings')
        ]);

        if (count(config('tjslash.backpack-page-manager.views'))) {
            CRUD::addField([
                'name' => 'view',
                'label' => trans('tjslash::backpack-page-manager.template'),
                'type' => 'select_from_array',
                'options' => config('tjslash.backpack-page-manager.views'),
                'allows_null' => true,
                'default' => null,
                'tab' => trans('tjslash::backpack-page-manager.common_settings')
            ]);
        }

        CRUD::addField([
            'name' => 'content',
            'label' => trans('tjslash::backpack-page-manager.content'),
            'type'=> backpack_pro() ? 'wysiwyg' : 'textarea',
            'tab' => trans('tjslash::backpack-page-manager.common_settings')
        ]);

        CRUD::addField([
            'name' => 'active',
            'label' => trans('tjslash::backpack-page-manager.active'),
            'type'=> 'checkbox',
            'tab' => trans('tjslash::backpack-page-manager.common_settings')
        ]);

        CRUD::addField([
            'name' => 'meta_title',
            'label' => trans('tjslash::backpack-page-manager.meta_title'),
            'tab' => trans('tjslash::backpack-page-manager.seo')
        ]);
        CRUD::addField([
            'name' => 'meta_description',
            'label' => trans('tjslash::backpack-page-manager.meta_description'),
            'type'=> 'textarea',
            'tab' => trans('tjslash::backpack-page-manager.seo')
        ]);
        CRUD::addField([
            'name' => 'meta_keywords',
            'label' => trans('tjslash::backpack-page-manager.meta_keywords'),
            'tab' => trans('tjslash::backpack-page-manager.seo')
        ]);
        CRUD::addField([
            'name' => 'meta_robots',
            'label' => trans('tjslash::backpack-page-manager.meta_robots'),
            'tab' => trans('tjslash::backpack-page-manager.seo')
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
