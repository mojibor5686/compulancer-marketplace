<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ItemDetails extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $view;
    public $itemDetails;
    public $type;

    public function __construct($itemDetails, $type, $view = null)
    {
        if (!$view) {
            $view = activeTemplate() . 'items.details.index';
        } else {
            $view = activeTemplate() . 'items.details.' . $view;
        }
        $this->view = $view;
        $this->itemDetails = $itemDetails;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $itemDetails = $this->itemDetails;
        $type = $this->type;
        $reviews = null;
        if ($type != 'job') {
            $reviews = $itemDetails->reviews()->latest()->with('user')->limit(6)->get();
        }
        return view($this->view, compact('itemDetails', 'reviews', 'type'));
    }
}
