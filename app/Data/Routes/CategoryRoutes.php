<?php

namespace App\Data\Routes;

class CategoryRoutes {
    const CATEGORIES = '/categories';
    const PUT_CATEGORY = '/categories/{id}';
    const RECIPES_BY_CATEGORY = '/categories/{id}';
    const UPDATE_VIEW = '/categories/updateView/{id}';
    const UPDATE_VIEWVUE = '/categories/updateViewVue/{id}';
    const POPULATE_CATEGORY = '/categories/populateCategory/{id?}';
}