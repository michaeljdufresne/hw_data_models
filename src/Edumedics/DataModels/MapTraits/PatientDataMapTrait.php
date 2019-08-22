<?php

namespace Edumedics\DataModels\MapTraits;

trait PatientDataMapTrait
{

    /**
     * @var array
     */
    public static $DrChronoPatientDataFields =  [
        'date_of_birth', 'gender', 'address', 'city', 'ethnicity', 'race', 'first_name',
        'last_name', 'middle_name', 'nick_name', 'maiden_name', 'home_phone', 'cell_phone', 'state', 'zip_code',
        'email', 'doctor', 'primary_insurance', 'patient_notes', 'custom_demographics', 'preferred_language'
    ];

    /**
     * @var array
     */
    public static $ClearableDrChronoPatientDataFields = [
        'ethnicity', 'race', 'first_name', 'last_name', 'middle_name',
        'nick_name', 'maiden_name', 'home_phone', 'cell_phone', 'email',
    ];

    /**
     * @var array
     */
    public static $HealthwardPatientDataFields = [
        'client_id', 'navmd_id', 'claimant', 'member_sequence', 'type', 'employee_id', 'agreement_signed', 'education', 'voicemail',
        'summary_preference', 'do_not_contact','industry'
    ];

}