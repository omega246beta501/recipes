<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;

class Table extends Component
{
    public $isMenuSet;
    public $recipes;
    public $keepedRecipesIds;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isMenuSet, $recipes, $keepedRecipesIds)
    {
        $this->recipes = $recipes;
        $this->isMenuSet = $isMenuSet;
        $this->$keepedRecipesIds = $keepedRecipesIds;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu.table');
    }
}
