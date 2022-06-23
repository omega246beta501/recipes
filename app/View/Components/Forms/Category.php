<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Category extends Component
{
    public $recipes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($recipes)
    {
        $this->recipes = $recipes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.category');
    }
}
