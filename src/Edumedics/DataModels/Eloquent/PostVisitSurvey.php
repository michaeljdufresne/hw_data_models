<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class PostVisitSurvey extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'post_visit_surveys';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    protected $fillable = [ 'patient_id', 'appointment_id', 'survey_type', 'survey_is_completed',
        'survey_completed_at', 'how_many_times', 'motivation', 'motivation_other', 'convenient', 'appointment_options',
        'convenient_locations', 'clinician_listens', 'clinician_explains', 'timely_response', 'call_office',
        'call_clinician', 'beneficial', 'rating', 'recommend', 'additional_comments', 'other_wellness' ];

}