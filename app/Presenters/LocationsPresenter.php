<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Core\LocationsModel;
use App\Core\UsersModel;
use BasePresenter;
use Nette;

final class LocationsPresenter extends BasePresenter
{

    /** @var Users @inject */
    private $locations;

    function __construct(LocationsModel $locations)
    {
        $this->locations = $locations;
    }

    public function beforeRender()
    {
        parent::beforeRender(); // TODO: Change the autogenerated stub

        $id = $this->getParameter('id');
        if($id !== null) {
            $this->template->location = $this->locations->getLocationById((int) $id);
        } else {
            $this->template->locations = $this->locations->getLocations();
        }
    }

    protected function createComponentEditLocationForm(): Nette\Application\UI\Form {
        $form = new Nette\Application\UI\Form;
            $form->addText('city', 'City')->setRequired('Vyplňte prosím pole');
            $form->addText('street_name', 'Street name')->setRequired('Vyplňte prosím pole');
            $form->addText('street_number', 'Street number')->setRequired('Vyplňte prosím pole');
            $form->addText('zip', 'Zip code')->setRequired('Vyplňte prosím pole');
            $form->addText('country', 'Country')->setRequired('Vyplňte prosím pole');
            $form->addText('name', 'Name')->setRequired('Vyplňte prosím pole');
            $form->addText('latitude', 'Latitude')->setRequired('Vyplňte prosím pole');
            $form->addText('longitude', 'Longitude')->setRequired('Vyplňte prosím pole');
            $id = $this->getParameter('id');
            if ($id !== null) {
                $location = $this->locations->getLocationById($id);
                $form['city']->setDefaultValue($location->city);
                $form['street_name']->setDefaultValue($location->streetName);
                $form['street_number']->setDefaultValue($location->streetNumber);
                $form['zip']->setDefaultValue($location->zip);
                $form['country']->setDefaultValue($location->country);
                $form['name']->setDefaultValue($location->name);
                $form['latitude']->setDefaultValue($location->latitude);
                $form['longitude']->setDefaultValue($location->longitude);
                $form->addSubmit('odeslat','Upravit lokaci');
            } else {
                $form->addSubmit('odeslat','Vytvořit lokaci');
            }
        $form->onSuccess[] = [$this, 'editLocationnFormSuceeded'];
        return $form;
    }

    public function editLocationnFormSuceeded(Nette\Application\UI\Form $form, \stdClass $values) {
        $id = $this->getParameter('id');
        if($id!== null) {
            $this->locations->editLocation(new \Location((array) $values, $id));
        } else {
            $this->locations->addLocation(new \Location((array) $values));
        }
        $this->flashMessage('Formulář byl úspěšně odeslán');
        $this->redirect('Locations:default');
    }

    function actionEditor($id): void {}
    function actionDetail($id): void {}
}
