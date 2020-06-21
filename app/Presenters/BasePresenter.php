<?php

use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    protected function createComponentHeader()
    {
        $control = new \HeaderControl();
        return $control;
    }

}