<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Events\Program\ProgramCreate;
use Edumedics\DataModels\Events\Program\ProgramUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Program extends Model {

    use Notifiable;

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';
    /**
     * @var string
     */
    protected $table = 'programs';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ProgramCreate::class,
        'updated' => ProgramUpdate::class
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programSuperseding()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\ProgramSuperseding', 'parent_program_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientPrograms()
    {
        return $this->hasMany('Edumedics\DataModels\Eloquent\ClientsPrograms', 'program_id', 'id');
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function isChronicConditionProgram($id)
    {
        $program = Program::find($id);
        return $program->is_cc_program;
    }

    /**
     * @return mixed
     */
    public static function getChronicConditionProgramIds()
    {
        return Program::where('is_cc_program', true)->pluck('id')->toArray();
    }

    /**
     * @return array
     */
    public static function getProgramNames()
    {
        return Program::all()->pluck('program_name')->toArray();
    }

    /**
     * @return array
     */
    public static function getProgramsById()
    {
        $programs = Program::all();
        $programsById = [];

        foreach ($programs as $program)
        {
            $programsById[$program->id] = $program->program_name;
        }
        return $programsById;
    }
    
}