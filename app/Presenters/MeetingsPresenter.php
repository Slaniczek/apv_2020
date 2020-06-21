<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Core\LocationsModel;
use App\Core\MeetingModel;
use App\Core\UsersModel;
use BasePresenter;
use Nette;
use Vodacek\Forms\Controls\DateInput;

final class MeetingsPresenter extends BasePresenter
{
    /** @var UsersModel @inject */
    private $users;

    /** @var MeetingModel @inject */
    private $meetings;

    /** @var LocationsModel @inject */
    private $locations;

    function __construct(UsersModel $users, MeetingModel $meetings, LocationsModel $locations)
    {
        $this->users = $users;
        $this->meetings = $meetings;
        $this->locations = $locations;
    }


    public function beforeRender()
    {
        parent::beforeRender(); // TODO: Change the autogenerated stub

        $meetings = $this->meetings->getMeetings(30);
        $this->template->meetings = $meetings;

        if(count($meetings) > 0) {
            $locations = $this->locations->getLocationsByIds(array_map(function ($item) {
                return $item->idLocation;
            }, $meetings));
            $this->template->locations = $locations;
        }
    }

    protected function createComponentEditMeetingForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form;
        $id = $this->getParameter('id');
        $persons = $this->users->getUsers(20);
        $locations = $this->locations->getLocations(20);

        $form->addTextArea('description', 'Description');
        $form->addText('duration', 'Duration')->setHtmlType('time');
        $form->addSelect('id_location', 'Location', array_reduce($locations, function ($locs, $location){
            $locs[$location->id] = $location->name;
            return $locs;
        }));


        if ($id !== null) {
            $form->addMultiSelect('persons', 'Persons', array_reduce($persons, function ($users, $person){
                $users[$person->id] = $person->nickname;
                return $users;
            }), count($persons));
            $meeting = $this->meetings->getMeetingById($id);
            $form['persons']->setDefaultValue(array_map(function ($item){return $item->id_person;}, $this->meetings->getPeopleOnMeeting($meeting->id)));
            $form['duration']->setDefaultValue($meeting->duration->format('%H:%I'));
            $form['description']->setDefaultValue($meeting->description);
            $form['id_location']->setDefaultValue($meeting->idLocation);
        }
        $form->addSubmit('odeslat', 'Uložit');
        $form->onSuccess[] = [$this, 'editMeetingFormSuceeded'];

        return $form;
    }


    public function editMeetingFormSuceeded(Nette\Application\UI\Form $form, \stdClass $values) {
        $id = $this->getParameter('id');
        $values = (array) $values;
        if($id!== null) {
            $this->meetings->editMeeting(new \Meeting($values, $id));
            $this->meetings->updatePersonsOnMeeting($values['persons'], $id);
        } else {
            $this->meetings->addMeeting(new \Meeting($values));
        }
        $this->flashMessage('Formulář byl úspěšně odeslán');
        $this->redirect('Meetings:');
    }

    function actionEditor($id): void {
        if (isset($id)){
            $id = $this->getParameter('id');
            $this->template->meeting = $this->meetings->getMeetingById((int) $id);
        }
    }
    function handleDelete($id): void {
        $this->meetings->removeMeeting($id);
    }
}