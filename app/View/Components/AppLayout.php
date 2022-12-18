<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{

    public $title;
    public $js;
    public $css;

    public function __construct($title = '', $js = '', $css = '')
    {
        $this->title = $title;
        $this->js = $js;
        $this->css = $css;
    }
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
