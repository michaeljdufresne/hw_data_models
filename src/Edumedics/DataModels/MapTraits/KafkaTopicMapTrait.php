<?php

namespace Edumedics\DataModels\MapTraits;

use Edumedics\DataModels\Events\Appointment\AppointmentCreate;
use Edumedics\DataModels\Events\Appointment\AppointmentDelete;
use Edumedics\DataModels\Events\Appointment\AppointmentUpdate;
use Edumedics\DataModels\Events\Audit\AuditLogEvent;
use Edumedics\DataModels\Events\Audit\AuditHttpRequestEvent;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignCreate;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignDelete;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignUpdate;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListCreate;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListDelete;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListUpdate;
use Edumedics\DataModels\Events\Campaigns\CampaignCreate;
use Edumedics\DataModels\Events\Campaigns\CampaignDelete;
use Edumedics\DataModels\Events\Campaigns\CampaignUpdate;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsCreate;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsUpdate;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteCreate;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteDelete;
use Edumedics\DataModels\Events\ClinicalNote\ClinicalNoteUpdate;
use Edumedics\DataModels\Events\Communication\CommunicationCreate;
use Edumedics\DataModels\Events\Communication\CommunicationDelete;
use Edumedics\DataModels\Events\Communication\CommunicationUpdate;
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
use Edumedics\DataModels\Events\Patient\PatientCreate;
use Edumedics\DataModels\Events\Patient\PatientDelete;
use Edumedics\DataModels\Events\Patient\PatientPostArchiveAction;
use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanCreate;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanDelete;
use Edumedics\DataModels\Events\PatientCarePlans\PatientCarePlanUpdate;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationCreate;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationDelete;
use Edumedics\DataModels\Events\PatientCarePlanValueExpiration\PatientCarePlanValueExpirationUpdate;
use Edumedics\DataModels\Events\PatientCommunicationLog\PatientCommunicationLogCreate;
use Edumedics\DataModels\Events\PatientCommunicationLog\PatientCommunicationLogDelete;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileCreate;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileDelete;
use Edumedics\DataModels\Events\PatientRiskProfile\PatientRiskProfileUpdate;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotCreate;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotDelete;
use Edumedics\DataModels\Events\PatientSnapshot\PatientSnapshotUpdate;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityCreate;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityDelete;
use Edumedics\DataModels\Events\ProgramEligibility\ProgramEligibilityUpdate;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentCreate;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentDelete;
use Edumedics\DataModels\Events\ProgramEnrollment\ProgramEnrollmentUpdate;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentCreate;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentDelete;
use Edumedics\DataModels\Events\ViimedProgramPathwayAssignment\ViimedPathwayAssignmentUpdate;

trait KafkaTopicMapTrait
{
    protected $kafkaTopicMap = [
        AuditHttpRequestEvent::class => 'audit_http_requests',
        AuditLogEvent::class=>'audit_log',
        CampaignCreate::class=>'campaigns',
        CampaignUpdate::class=>'campaigns',
        CampaignDelete::class=>'campaigns',
        CallCampaignCreate::class=>'call_campaigns',
        CallCampaignUpdate::class=>'call_campaigns',
        CallCampaignDelete::class=>'call_campaigns',
        CallCampaignsParticipantListCreate::class=>'call_campaigns_participant_list',
        CallCampaignsParticipantListUpdate::class=>'call_campaigns_participant_list',
        CallCampaignsParticipantListDelete::class=>'call_campaigns_participant_list',
        MailCampaignCreate::class=>'mail_campaigns',
        MailCampaignUpdate::class=>'mail_campaigns',
        MailCampaignDelete::class=>'mail_campaigns',
        MailCampaignParticipantListCreate::class=>'mail_campaigns_participant_list',
        MailCampaignParticipantListUpdate::class=>'mail_campaigns_participant_list',
        MailCampaignParticipantListDelete::class=>'mail_campaigns_participant_list',
        EmailCampaignCreate::class=>'email_campaigns',
        EmailCampaignUpdate::class=>'email_campaigns',
        EmailCampaignDelete::class=>'email_campaigns',
        EmailCampaignParticipantListCreate::class=>'email_campaigns_participant_list',
        EmailCampaignParticipantListUpdate::class=>'email_campaigns_participant_list',
        EmailCampaignParticipantListDelete::class=>'email_campaigns_participant_list',
        ClientProgramsCreate::class => 'client_programs',
        ClientProgramsUpdate::class => 'client_programs',
        CommunicationCreate::class => 'drchrono_communications',
        CommunicationDelete::class => 'drchrono_communications',
        CommunicationUpdate::class => 'drchrono_communications',
        PatientCommunicationLogCreate::class => 'patient_communication_log',
        PatientCommunicationLogDelete::class => 'patient_communication_log',
        LabCreate::class => 'drchrono_labs',
        LabDelete::class => 'drchrono_labs',
        LabUpdate::class => 'drchrono_labs',
        ManualLabResultCreate::class => 'drchrono_manual_lab_results',
        ManualLabResultDelete::class => 'drchrono_manual_lab_results',
        ManualLabResultUpdate::class => 'drchrono_manual_lab_results',
        PatientCreate::class => 'patients',
        PatientUpdate::class => 'patients',
        PatientDelete::class => 'patients',
        PatientPostArchiveAction::class => 'patients',
        AppointmentCreate::class => 'appointments',
        AppointmentUpdate::class => 'appointments',
        AppointmentDelete::class => 'appointments',
        ClinicalNoteCreate::class => 'clinical_notes',
        ClinicalNoteUpdate::class => 'clinical_notes',
        ClinicalNoteDelete::class => 'clinical_notes',
        LabResultViewCreate::class => 'lab_result_views',
        LabResultViewUpdate::class => 'lab_result_views',
        LabResultViewDelete::class => 'lab_result_views',
        ProgramEligibilityCreate::class => 'program_eligibility',
        ProgramEligibilityUpdate::class => 'program_eligibility',
        ProgramEligibilityDelete::class => 'program_eligibility',
        ProgramEnrollmentCreate::class => 'program_enrollment',
        ProgramEnrollmentUpdate::class => 'program_enrollment',
        ProgramEnrollmentDelete::class => 'program_enrollment',
        PatientRiskProfileCreate::class => 'patient_risk_profiles',
        PatientRiskProfileUpdate::class => 'patient_risk_profiles',
        PatientRiskProfileDelete::class => 'patient_risk_profiles',
        PatientCarePlanCreate::class => 'patient_care_plans',
        PatientCarePlanUpdate::class => 'patient_care_plans',
        PatientCarePlanDelete::class => 'patient_care_plans',
        PatientSnapshotCreate::class => 'patient_snapshots',
        PatientSnapshotDelete::class => 'patient_snapshots',
        PatientSnapshotUpdate::class => 'patient_snapshots',
        PatientCarePlanValueExpirationCreate::class => 'patient_care_plan_value_expirations',
        PatientCarePlanValueExpirationDelete::class => 'patient_care_plan_value_expirations',
        PatientCarePlanValueExpirationUpdate::class => 'patient_care_plan_value_expirations',
        ViimedPathwayAssignmentCreate::class => 'viimed_program_pathway_assignments',
        ViimedPathwayAssignmentUpdate::class => 'viimed_program_pathway_assignments',
        ViimedPathwayAssignmentDelete::class => 'viimed_program_pathway_assignments',
        EmVitalsAssessmentObservationCreate::class => 'emvitals_assessment_observations'
    ];

    protected function getTopic($eventType)
    {
        if (!isset($this->kafkaTopicMap[$eventType]))
        {
            throw new \Exception('Unable to find Kafka topic for event: ' . $eventType);
        }

        return $this->kafkaTopicMap[$eventType];
    }

}