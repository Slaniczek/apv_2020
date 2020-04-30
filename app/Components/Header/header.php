<?php

use Nette\Application\UI\Control;
class HeaderControl extends Control
{
    public function render()
    {
        $template = $this->template;
        $template->setFile(__DIR__ . '/template/header.latte');
        $template->render();
    }
}