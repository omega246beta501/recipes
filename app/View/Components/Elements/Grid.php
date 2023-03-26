<?php

namespace App\View\Components\Elements;

use Illuminate\View\Component;

class Grid extends Component
{
    public $recipe;
    public $ingredients;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($recipe, $ingredients)
    {
        $this->recipe = $recipe;
        $this->ingredients = $ingredients;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.elements.grid');
    }
}
