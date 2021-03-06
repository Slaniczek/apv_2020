<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Core\CountsModel;
use BasePresenter;
use Nette;

final class HomepagePresenter extends BasePresenter {

    private $counts;

    function __construct(CountsModel $counts)
    {
        $this->counts = $counts;
    }

    protected function beforeRender()
    {
        parent::beforeRender(); // TODO: Change the autogenerated stub

        $this->template->persons = $this->counts->getPersonsCount();
        $this->template->meetings = $this->counts->getMeetingsCount();
        $this->template->locations = $this->counts->getLocationsCount();
        $this->template->relations = $this->counts->getRelationsCount();
    }
}
