<?php

namespace Edumedics\DataModels\Aggregate;


use Edumedics\DataModels\Aggregate\Office\ExamRoom;
use Edumedics\DataModels\Aggregate\Office\OnlineTimeslot;
use Edumedics\DataModels\Dto\Common\OfficeDto;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{

    /**
     * @var string
     */
    protected $table = 'drchrono_offices';

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @param $drChronoOffice
     */
    public function populate($drChronoOffice)
    {
        $examRooms = [];
        $timeSlots = [];
        foreach ($drChronoOffice as $k => $v)
        {
            switch ($k)
            {
                case 'id':
                    $this->drchrono_office_id = (int)$v;
                    break;

                case 'exam_rooms':
                    foreach ($v as $examRoomArray)
                    {
                        $examRoom = new ExamRoom();
                        $examRoom->fill($examRoomArray);
                        $examRooms[] =$examRoom;
                    }
                    break;

                case 'online_timeslots':
                    foreach ($v as $timeSlotArray)
                    {
                        $timeslot = new OnlineTimeslot();
                        $timeslot->fill($timeSlotArray);
                        $timeSlots[] = $timeslot;
                    }
                    break;

                default:
                    $this->{$k} = $v;
            }
        }

        $this->save();
        $this->saveExamRooms($examRooms);
        $this->saveTimeslots($timeSlots);
    }

    /**
     * @param OfficeDto $office
     */
    public function populateFromDto(OfficeDto $office)
    {
        foreach ($office as $k => $v)
        {
            switch ($k)
            {
                case 'active':
                    $this->archived = !((boolean)$v) ? 1 : 0;
                    break;
                case 'office_id':
                case 'external_ids':
                    break;
                default:
                    $this->{$k} = $v;
            }
        }
    }

    private function saveExamRooms($examRooms)
    {
        $this->examRooms()->delete();
        foreach ($examRooms as $examRoom)
        {
            $this->examRooms()->save($examRoom);
        }
    }

    private function saveTimeslots($timeSlots)
    {
        $this->onlineTimeslots()->delete();
        foreach ($timeSlots as $timeSlot)
        {
            $this->onlineTimeslots()->save($timeSlot);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examRooms()
    {
        return $this->hasMany('Edumedics\DataModels\Aggregate\Office\ExamRoom', 'office_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function onlineTimeslots()
    {
        return $this->hasMany('Edumedics\DataModels\Aggregate\Office\OnlineTimeslot', 'office_id', 'id');
    }

}