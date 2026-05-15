<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Item extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $view;
    public $product;
    public $type;

    public function __construct($product, $type, $view = null)
    {
        if (!$view) {
            $view = activeTemplate() . 'items.item';
        } else {
            $view = activeTemplate() . 'items.' . $view;
        }

        $this->view    = $view;
        $this->type    = $type;
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $product = $this->product;
        $type    = $this->type;
        return view($this->view, compact('product', 'type'));
    }
}
