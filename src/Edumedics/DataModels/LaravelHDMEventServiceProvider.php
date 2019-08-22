<?php

namespace Edumedics\DataModels;

use Edumedics\DataModels\Events\Audit\AuditHttpRequestEvent;
use Edumedics\DataModels\Events\Appointment\AppointmentCreate;
use Edumedics\DataModels\Events\Appointment\AppointmentDelete;
use Edumedics\DataModels\Events\Appointment\AppointmentUpdate;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignCreate;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignDelete;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignUpdate;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListCreate;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListDelete;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListUpdate;
use Edumedics\DataModels\Events\Campaigns\CampaignCreate;
use Edumedics\DataModels\Events\Campaigns\CampaignDelete;
use Edumedics\DataModels\Events\Campaigns\CampaignUpdate;
use Edumedics\DataModels\Events\Client\ClientArchive;
use Edumedics\DataModels\Events\Client\ClientCreate;
use Edumedics\DataModels\Events\Client\ClientUnarchive;
use Edumedics\DataModels\Events\Client\ClientUpdate;
use Edumedics\DataModels\Events\ClientCampaignDescriptions\ClientCampaignDescriptionsCreate;
use Edumedics\DataModels\Events\ClientCampaignDescriptions\ClientCampaignDescriptionsUpdate;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsCreate;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsUpdate;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteCreate;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteDelete;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteUpdate;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditCreate;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditDelete;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditUpdate;
use Edumedics\DataModels\Events\Communication\CommunicationCreate;
use Edumedics\DataModels\Events\Communication\CommunicationDelete;
use Edumedics\DataModels\Events\Communication\CommunicationUpdate;
use Edumedics\DataModels\Events\CommunicationCampaigns\CommunicationCampaignsCreate;
use Edumedics\DataModels\Events\CommunicationCampaigns\CommunicationCampaignsDelete;
use Edumedics\DataModels\Events\CommunicationCampaigns\CommunicationCampaignsUpdate;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListCreate;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListUpdate;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignCreate;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignDelete;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignUpdate;
use Edumedics\DataModels\Events\EmVitalsAssessmentObservation\EmVitalsAssessmentObservationCreate;
use Edumedics\DataModels\Events\Lab\LabCreate;
use Edumedics\DataModels\Events\Lab\LabDelete;
use Edumedics\DataModels\Events\Lab\LabUpdate;
use Edumedics\DataModels\Events\LabResultView\LabResultViewCreate;
use Edumedics\DataModels\Events\LabResultView\LabResultViewDelete;
use Edumedics\DataModels\Events\LabResultView\LabResultViewUpdate;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListCreate;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListUpdate;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignCreate;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignDelete;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignUpdate;
use Edumedics\DataModels\Events\ManualLabResult\ManualLabResultCreate;
use Edumedics\DataModels\Events\ManualLabResult\ManualLabResultDelete;
use Edumedics\DataModels\Events\ManualLabResult\ManualLabResultUpdate;
use Edumedics\DataModels\Events\ModelReconciliations\ModelReconciliationsDelete;
use Edumedics\DataModels\Events\ModelReconciliations\ModelReconciliationsUpdate;
use Edumedics\DataModels\Events\Notifications\NotificationCreate;
use Edumedics\DataModels\Events\Notifications\NotificationUpdate;
use Edumedics\DataModels\Events\Patient\PatientArchive;
use Edumedics\DataModels\Events\Patient\PatientCreate;
use Edumedics\DataModels\Events\Patient\PatientDelete;
use Edumedics\DataModels\Events\Patient\PatientPostArchiveAction;
use Edumedics\DataModels\Events\Patient\PatientUnarchive;
use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanCreate;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanDelete;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanUpdate;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationCreate;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationDelete;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationUpdate;
use Edumedics\DataModels\Events\PatientCommunicationLog\PatientCommunicationLogCreate;
use Edumedics\DataModels\Events\PatientCommunicationLog\PatientCommunicationLogDelete;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesCreate;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesDelete;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesUpdate;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileCreate;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileDelete;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileUpdate;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotCreate;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotUpdate;
use Edumedics\DataModels\Events\Program\ProgramCreate;
use Edumedics\DataModels\Events\Program\ProgramUpdate;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityCreate;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityDelete;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityUpdate;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentCreate;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentDelete;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentUpdate;
use Edumedics\DataModels\Events\Tasks\TaskCreate;
use Edumedics\DataModels\Events\Tasks\TaskDelete;
use Edumedics\DataModels\Events\Tasks\TaskUpdate;
use Edumedics\DataModels\Events\User\UserCreate;
use Edumedics\DataModels\Events\User\UserDelete;
use Edumedics\DataModels\Events\User\UserUpdate;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentCreate;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentDelete;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentUpdate;
use Edumedics\DataModels\Listeners\Audit\KafkaPublishAudit;
use Edumedics\DataModels\Listeners\Appointment\AppointmentCascadeDelete;
use Edumedics\DataModels\Listeners\Appointment\KafkaPublishAppointment;
use Edumedics\DataModels\Listeners\Audit\KafkaPublishHttpRequestAudit;
use Edumedics\DataModels\Listeners\CallCampaign\KafkaPublishCallCampaign;
use Edumedics\DataModels\Listeners\CallCampaignsParticipantList\KafkaPublishCallList;
use Edumedics\DataModels\Listeners\Campaign\KafkaPublishCampaign;
use Edumedics\DataModels\Listeners\Client\ClientCascadeArchive;
use Edumedics\DataModels\Listeners\Client\ClientCascadeUnarchive;
use Edumedics\DataModels\Listeners\ClientPrograms\KafkaPublishClientProgram;
use Edumedics\DataModels\Listeners\ClinicalNote\KafkaPublishClinicalNote;
use Edumedics\DataModels\Listeners\Communication\KafkaPublishCommunication;
use Edumedics\DataModels\Listeners\EmailCampaign\KafkaPublishEmailCampaign;
use Edumedics\DataModels\Listeners\EmailCampaignsParticipantList\KafkaPublishEmailCampaignList;
use Edumedics\DataModels\Listeners\EmVitalsAssessmentObservation\KafkaPublishEmVitalsAssessmentObservation;
use Edumedics\DataModels\Listeners\Lab\KafkaPublishLab;
use Edumedics\DataModels\Listeners\LabResultView\KafkaPublishLabResultView;
use Edumedics\DataModels\Listeners\MailCampaign\KafkaPublishMailCampaign;
use Edumedics\DataModels\Listeners\MailCampaignsParticipantList\KafkaPublishMailCampaignList;
use Edumedics\DataModels\Listeners\ManualLabResult\KafkaPublishManualLabResult;
use Edumedics\DataModels\Listeners\Notifications\NotificationsCreateBroadcastListener;
use Edumedics\DataModels\Listeners\Notifications\NotificationsUpdateBroadcastListener;
use Edumedics\DataModels\Listeners\Patient\FlagPossiblePatientDuplicates;
use Edumedics\DataModels\Listeners\Patient\KafkaPublishPatient;
use Edumedics\DataModels\Listeners\Patient\PatientCascadeArchive;
use Edumedics\DataModels\Listeners\Patient\PatientCascadeDelete;
use Edumedics\DataModels\Listeners\Patient\PatientCascadeUnarchive;
use Edumedics\DataModels\Listeners\Patient\UpdatePatientArchiveStatus;
use Edumedics\DataModels\Listeners\PatientCarePlan\KafkaPublishPatientCarePlan;
use Edumedics\DataModels\Listeners\PatientCarePlanValueExpiration\KafkaPublishPatientCarePlanValueExpiration;
use Edumedics\DataModels\Listeners\PatientClient\CreatePatientClient;
use Edumedics\DataModels\Listeners\PatientClient\UpdatePatientClient;
use Edumedics\DataModels\Listeners\PatientCommunicationLog\KafkaPublishPatientCommunicationLog;
use Edumedics\DataModels\Listeners\PatientIdMap\CreatePatientIdMap;
use Edumedics\DataModels\Listeners\PatientIdMap\UpdatePatientIdMap;
use Edumedics\DataModels\Listeners\PatientSnapshot\KafkaPublishPatientSnapshot;
use Edumedics\DataModels\Listeners\PatientSubscription\CreatePatientSubscription;
use Edumedics\DataModels\Listeners\ProgramEligibility\KafkaPublishProgramEligibility;
use Edumedics\DataModels\Listeners\ProgramEnrollment\KafkaPublishProgramEnrollment;
use Edumedics\DataModels\Listeners\RiskProfile\KafkaPublishRiskProfile;
use Edumedics\DataModels\Listeners\Tasks\TaskCreateBroadcastListener;
use Edumedics\DataModels\Listeners\Tasks\TaskDeleteBroadcastListener;
use Edumedics\DataModels\Listeners\Tasks\TaskUpdateBroadcastListener;
use Edumedics\DataModels\Listeners\ViimedProgramPathwayAssignment\KafkaPublishViimedPathwayAssignment;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LaravelHDMEventServiceProvider extends BaseServiceProvider
{

    /**
     * The event listener mappings for the Healthward Data Models package.
     *
     * @var array
     */
    protected $listen = [

        //Audit http requests
        AuditHttpRequestEvent::class => [
            KafkaPublishHttpRequestAudit::class
        ],
        // Appointments
        AppointmentCreate::class => [
            KafkaPublishAudit::class,
            KafkaPublishAppointment::class
        ],
        AppointmentDelete::class => [
            KafkaPublishAudit::class,
            AppointmentCascadeDelete::class,
            KafkaPublishAppointment::class,
        ],
        AppointmentUpdate::class => [
            KafkaPublishAudit::class,
            KafkaPublishAppointment::class
        ],

        //Campaigns
        CampaignCreate::class => [
            KafkaPublishCampaign::class,
            KafkaPublishAudit::class,
        ],
        CampaignUpdate::class => [
            KafkaPublishCampaign::class,
            KafkaPublishAudit::class,
        ],
        CampaignDelete::class => [
            KafkaPublishCampaign::class,
            KafkaPublishAudit::class,
        ],

        //Call Campaigns
        CallCampaignCreate::class => [
            KafkaPublishCallCampaign::class,
            KafkaPublishAudit::class,
        ],
        CallCampaignUpdate::class => [
            KafkaPublishCallCampaign::class,
            KafkaPublishAudit::class,
        ],
        CallCampaignDelete::class => [
            KafkaPublishCallCampaign::class,
            KafkaPublishAudit::class,
        ],

        //Email Campaigns
        EmailCampaignCreate::class => [
            KafkaPublishEmailCampaign::class,
            KafkaPublishAudit::class,
        ],
        EmailCampaignUpdate::class => [
            KafkaPublishEmailCampaign::class,
            KafkaPublishAudit::class,
        ],
        EmailCampaignDelete::class => [
            KafkaPublishEmailCampaign::class,
            KafkaPublishAudit::class,
        ],

        //Mail Campaigns
        MailCampaignCreate::class => [
            KafkaPublishMailCampaign::class,
            KafkaPublishAudit::class,
        ],
        MailCampaignUpdate::class => [
            KafkaPublishMailCampaign::class,
            KafkaPublishAudit::class,
        ],
        MailCampaignDelete::class => [
            KafkaPublishMailCampaign::class,
            KafkaPublishAudit::class,
        ],

        // Campaigns Call List
        CallCampaignsParticipantListCreate::class => [
            KafkaPublishAudit::class,
            KafkaPublishCallList::class
        ],
        CallCampaignsParticipantListUpdate::class => [
            KafkaPublishAudit::class,
            KafkaPublishCallList::class
        ],
        CallCampaignsParticipantListDelete::class => [
            KafkaPublishAudit::class,
            KafkaPublishCallList::class
        ],
         MailCampaignParticipantListCreate::class => [
            KafkaPublishAudit::class,
            KafkaPublishMailCampaignList::class
        ],
        MailCampaignParticipantListUpdate::class => [
            KafkaPublishAudit::class,
            KafkaPublishMailCampaignList::class
        ],
        MailCampaignParticipantListDelete::class => [
            KafkaPublishAudit::class,
            KafkaPublishMailCampaignList::class
        ],
        EmailCampaignParticipantListCreate::class => [
            KafkaPublishAudit::class,
            KafkaPublishEmailCampaignList::class
        ],
        EmailCampaignParticipantListUpdate::class => [
            KafkaPublishAudit::class,
            KafkaPublishEmailCampaignList::class
        ],
        EmailCampaignParticipantListDelete::class => [
            KafkaPublishAudit::class,
            KafkaPublishEmailCampaignList::class
        ],

        // Client
        ClientCreate::class => [
            KafkaPublishAudit::class
        ],
        ClientUpdate::class => [
            KafkaPublishAudit::class
        ],
        ClientArchive::class => [
            ClientCascadeArchive::class
        ],
        ClientUnarchive::class => [
            ClientCascadeUnarchive::class
        ],

        // Client Campaign Descriptions
        ClientCampaignDescriptionsCreate::class => [
            KafkaPublishAudit::class
        ],
        ClientCampaignDescriptionsUpdate::class => [
            KafkaPublishAudit::class
        ],

        // Client Program
        ClientProgramsCreate::class => [
            KafkaPublishAudit::class,
            KafkaPublishClientProgram::class
        ],
        ClientProgramsUpdate::class => [
            KafkaPublishAudit::class,
            KafkaPublishClientProgram::class
        ],

        // Clinical Notes
        ClinicalNoteCreate::class => [
            KafkaPublishClinicalNote::class,
        ],
        ClinicalNoteUpdate::class => [
            KafkaPublishClinicalNote::class,
        ],
        ClinicalNoteDelete::class => [
            KafkaPublishClinicalNote::class,
        ],

        // Collaborative MD Audit
        CollaborativeMDAuditCreate::class => [
            KafkaPublishAudit::class
        ],
        CollaborativeMDAuditUpdate::class => [
            KafkaPublishAudit::class
        ],
        CollaborativeMDAuditDelete::class => [
            KafkaPublishAudit::class
        ],

        // Communication
        CommunicationCreate::class => [
            KafkaPublishCommunication::class
        ],
        CommunicationUpdate::class => [
            KafkaPublishCommunication::class
        ],
        CommunicationDelete::class => [
            KafkaPublishCommunication::class
        ],

        // Communication Campaigns
        CommunicationCampaignsCreate::class => [
            KafkaPublishAudit::class
        ],
        CommunicationCampaignsUpdate::class => [
            KafkaPublishAudit::class
        ],
        CommunicationCampaignsDelete::class => [
            KafkaPublishAudit::class
        ],

        // EmVitals Assessment Observation
        EmVitalsAssessmentObservationCreate::class => [
            KafkaPublishEmVitalsAssessmentObservation::class
        ],

        // Labs
        LabCreate::class => [
            KafkaPublishLab::class
        ],
        LabUpdate::class => [
            KafkaPublishLab::class
        ],
        LabDelete::class => [
            KafkaPublishLab::class
        ],

        // Lab Result View
        LabResultViewCreate::class => [
            KafkaPublishLabResultView::class,
        ],
        LabResultViewUpdate::class => [
            KafkaPublishLabResultView::class,
        ],
        LabResultViewDelete::class => [
            KafkaPublishLabResultView::class,
        ],

        // Manual Lab Result
        ManualLabResultCreate::class => [
            KafkaPublishManualLabResult::class
        ],
        ManualLabResultUpdate::class => [
            KafkaPublishManualLabResult::class
        ],
        ManualLabResultDelete::class => [
            KafkaPublishManualLabResult::class
        ],

        // Model Reconciliations
        ModelReconciliationsUpdate::class => [
            KafkaPublishAudit::class
        ],
        ModelReconciliationsDelete::class => [
            KafkaPublishAudit::class
        ],

        // Notifications
        NotificationCreate::class => [
            NotificationsCreateBroadcastListener::class
        ],
        NotificationUpdate::class => [
            NotificationsUpdateBroadcastListener::class
        ],

        // Patient
        PatientCreate::class => [
            KafkaPublishAudit::class,
            CreatePatientClient::class,
            CreatePatientIdMap::class,
            CreatePatientSubscription::class,
            KafkaPublishPatient::class,
            FlagPossiblePatientDuplicates::class
        ],
        PatientUpdate::class => [
            KafkaPublishAudit::class,
            UpdatePatientClient::class,
            UpdatePatientArchiveStatus::class,
            UpdatePatientIdMap::class,
            KafkaPublishPatient::class,
            FlagPossiblePatientDuplicates::class
        ],
        PatientDelete::class => [
            KafkaPublishAudit::class,
            PatientCascadeDelete::class,
            KafkaPublishPatient::class
        ],
        PatientArchive::class => [
            PatientCascadeArchive::class
        ],
        PatientUnarchive::class => [
            PatientCascadeUnarchive::class
        ],
        PatientPostArchiveAction::class => [
            KafkaPublishPatient::class,
        ],

        // Patient Care Plan
        PatientCarePlanCreate::class => [
            KafkaPublishPatientCarePlan::class,
        ],
        PatientCarePlanUpdate::class => [
            KafkaPublishPatientCarePlan::class,
        ],
        PatientCarePlanDelete::class => [
            KafkaPublishPatientCarePlan::class,
        ],

        // Patient Care Plan Value Expiration
        PatientCarePlanValueExpirationCreate::class => [
            KafkaPublishPatientCarePlanValueExpiration::class
        ],
        PatientCarePlanValueExpirationUpdate::class => [
            KafkaPublishPatientCarePlanValueExpiration::class
        ],
        PatientCarePlanValueExpirationDelete::class => [
            KafkaPublishPatientCarePlanValueExpiration::class
        ],

        // Patient Communication Log
        PatientCommunicationLogCreate::class => [
            KafkaPublishPatientCommunicationLog::class
        ],
        PatientCommunicationLogDelete::class => [
            KafkaPublishPatientCommunicationLog::class
        ],

        //Patient Diagnoses
        PatientDiagnosesCreate::class => [
            KafkaPublishAudit::class
        ],
        PatientDiagnosesUpdate::class => [
            KafkaPublishAudit::class
        ],
        PatientDiagnosesDelete::class => [
            KafkaPublishAudit::class
        ],

        // Patient Risk Profile
        PatientRiskProfileCreate::class => [
            KafkaPublishRiskProfile::class,
        ],
        PatientRiskProfileUpdate::class => [
            KafkaPublishRiskProfile::class,
        ],
        PatientRiskProfileDelete::class => [
            KafkaPublishRiskProfile::class,
        ],

        // Patient Snapshot
        PatientSnapshotCreate::class => [
            KafkaPublishPatientSnapshot::class
        ],
        PatientSnapshotUpdate::class => [
            KafkaPublishPatientSnapshot::class
        ],

        // Program
        ProgramCreate::class => [
            KafkaPublishAudit::class
        ],
        ProgramUpdate::class => [
            KafkaPublishAudit::class
        ],

        // Program Eligibility
        ProgramEligibilityCreate::class => [
            KafkaPublishAudit::class,
            KafkaPublishProgramEligibility::class
        ],
        ProgramEligibilityUpdate::class => [
            KafkaPublishAudit::class,
            KafkaPublishProgramEligibility::class
        ],
        ProgramEligibilityDelete::class => [
            KafkaPublishAudit::class,
            KafkaPublishProgramEligibility::class
        ],

        // Program Enrollment
        ProgramEnrollmentCreate::class => [
            KafkaPublishAudit::class,
            KafkaPublishProgramEnrollment::class
        ],
        ProgramEnrollmentUpdate::class => [
            KafkaPublishAudit::class,
            KafkaPublishProgramEnrollment::class
        ],
        ProgramEnrollmentDelete::class => [
            KafkaPublishAudit::class,
            KafkaPublishProgramEnrollment::class
        ],

        // Tasks
        TaskCreate::class => [
            KafkaPublishAudit::class,
            TaskCreateBroadcastListener::class
        ],
        TaskUpdate::class => [
            KafkaPublishAudit::class,
            TaskUpdateBroadcastListener::class
        ],
        TaskDelete::class => [
            KafkaPublishAudit::class,
            TaskDeleteBroadcastListener::class
        ],

        // User
        UserCreate::class => [
            KafkaPublishAudit::class
        ],
        UserUpdate::class => [
            KafkaPublishAudit::class
        ],
        UserDelete::class => [
            KafkaPublishAudit::class
        ],

        // ViimedProgramPathwayAssignment
        ViimedPathwayAssignmentCreate::class => [
            KafkaPublishViimedPathwayAssignment::class
        ],
        ViimedPathwayAssignmentUpdate::class => [
            KafkaPublishViimedPathwayAssignment::class
        ],
        ViimedPathwayAssignmentDelete::class => [
            KafkaPublishViimedPathwayAssignment::class
        ]

    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->listens() as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            Event::subscribe($subscriber);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}