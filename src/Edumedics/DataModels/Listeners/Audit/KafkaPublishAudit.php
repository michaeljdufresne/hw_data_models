<?php

namespace Edumedics\DataModels\Listeners\Audit;


use Edumedics\DataModels\Eloquent\AuditLog;
use Edumedics\DataModels\Eloquent\User;
use Edumedics\DataModels\Events\Appointment\AppointmentCreate;
use Edumedics\DataModels\Events\Appointment\AppointmentDelete;
use Edumedics\DataModels\Events\Appointment\AppointmentUpdate;
use Edumedics\DataModels\Events\Audit\AuditLogEvent;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignCreate;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignDelete;
use Edumedics\DataModels\Events\CallCampaigns\CallCampaignUpdate;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListCreate;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListDelete;
use Edumedics\DataModels\Events\CallCampaignsParticipantList\CallCampaignsParticipantListUpdate;
use Edumedics\DataModels\Events\Client\ClientCreate;
use Edumedics\DataModels\Events\Client\ClientUpdate;
use Edumedics\DataModels\Events\ClientCampaignDescriptions\ClientCampaignDescriptionsCreate;
use Edumedics\DataModels\Events\ClientCampaignDescriptions\ClientCampaignDescriptionsUpdate;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsCreate;
use Edumedics\DataModels\Events\ClientPrograms\ClientProgramsUpdate;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditCreate;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditDelete;
use Edumedics\DataModels\Events\CollaborativeMDAudits\CollaborativeMDAuditUpdate;
use Edumedics\DataModels\Events\CommunicationCampaigns\CommunicationCampaignsCreate;
use Edumedics\DataModels\Events\CommunicationCampaigns\CommunicationCampaignsDelete;
use Edumedics\DataModels\Events\CommunicationCampaigns\CommunicationCampaignsUpdate;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListCreate;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\EmailCampaignParticipantList\EmailCampaignParticipantListUpdate;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignCreate;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignDelete;
use Edumedics\DataModels\Events\EmailCampaigns\EmailCampaignUpdate;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListCreate;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListDelete;
use Edumedics\DataModels\Events\MailCampaignParticipantList\MailCampaignParticipantListUpdate;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignCreate;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignDelete;
use Edumedics\DataModels\Events\MailCampaigns\MailCampaignUpdate;
use Edumedics\DataModels\Events\ModelReconciliations\ModelReconciliationsDelete;
use Edumedics\DataModels\Events\ModelReconciliations\ModelReconciliationsUpdate;
use Edumedics\DataModels\Events\Patient\PatientCreate;
use Edumedics\DataModels\Events\Patient\PatientDelete;
use Edumedics\DataModels\Events\Patient\PatientUpdate;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesCreate;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesDelete;
use Edumedics\DataModels\Events\PatientDiagnoses\PatientDiagnosesUpdate;
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
use Edumedics\DataModels\MapTraits\KafkaTopicMapTrait;
use Edumedics\DataModels\Events\Event;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Auth;
use SentryHealth\Kafka\Models\EventTransferModel;

class KafkaPublishAudit extends ListenerAppResolver
{
    use KafkaTopicMapTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('KafkaProxyService');
    }


    /**
     * @param Event $event
     * @throws \ReflectionException
     */
    public function handle(Event $event)
    {
        $eventType = get_class($event);
        $auditEntry = new AuditLog();

        if($eventType != PatientUpdate::class && $eventType != PatientCreate::class && $eventType != PatientDelete::class)
        {
            $auditEntry->changed_by = Auth::id();
        }
        else
        {
            $auditEntry->changed_by = isset($event->patient->usersApiToken)
                ? $event->patient->usersApiToken->user_id : null;
        }

        switch($eventType)
        {
            case AppointmentCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->appointment->_id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->appointment)))->getShortName();
                break;
            case AppointmentUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->appointment->_id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->appointment)))->getShortName();
                $auditEntry->previous_object_content = json_encode($event->appointment->getOriginal());
                break;
            case AppointmentDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->appointment->_id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->appointment)))->getShortName();
                $auditEntry->previous_object_content = json_encode($event->appointment->getOriginal());
                break;
            case CallCampaignsParticipantListCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->callCampaignsParticipantList->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->callCampaignsParticipantList)))->getShortName();
                break;
            case CallCampaignsParticipantListDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->callCampaignsParticipantList->id;
                $auditEntry->previous_object_content = json_encode($event->callCampaignsParticipantList->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->callCampaignsParticipantList)))->getShortName();
                break;
            case CallCampaignsParticipantListUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->callCampaignsParticipantList->id;
                $auditEntry->previous_object_content = json_encode($event->callCampaignsParticipantList->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->callCampaignsParticipantList)))->getShortName();
                break;
            case MailCampaignParticipantListCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->mailCampaignsParticipantList->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->mailCampaignsParticipantList)))->getShortName();
                break;
            case MailCampaignParticipantListDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->mailCampaignsParticipantList->id;
                $auditEntry->previous_object_content = json_encode($event->mailCampaignsParticipantList->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->mailCampaignsParticipantList)))->getShortName();
                break;
            case MailCampaignParticipantListUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->mailCampaignsParticipantList->id;
                $auditEntry->previous_object_content = json_encode($event->mailCampaignsParticipantList->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->mailCampaignsParticipantList)))->getShortName();
                break;
            case EmailCampaignParticipantListCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->emailCampaignsParticipantList->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->emailCampaignsParticipantList)))->getShortName();
                break;
            case EmailCampaignParticipantListDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->emailCampaignsParticipantList->id;
                $auditEntry->previous_object_content = json_encode($event->emailCampaignsParticipantList->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->emailCampaignsParticipantList)))->getShortName();
                break;
            case EmailCampaignParticipantListUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->emailCampaignsParticipantList->id;
                $auditEntry->previous_object_content = json_encode($event->emailCampaignsParticipantList->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->emailCampaignsParticipantList)))->getShortName();
                break;
            case CallCampaignCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->callCampaign->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->callCampaign)))->getShortName();
                break;
            case CallCampaignDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->callCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->callCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->callCampaign)))->getShortName();
                break;
            case CallCampaignUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->callCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->callCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->callCampaign)))->getShortName();
                break;
            case MailCampaignCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->mailCampaign->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->mailCampaign)))->getShortName();
                break;
            case MailCampaignDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->mailCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->mailCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->mailCampaign)))->getShortName();
                break;
            case MailCampaignUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->mailCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->mailCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->mailCampaign)))->getShortName();
                break;
            case EmailCampaignCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->emailCampaign->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->emailCampaign)))->getShortName();
                break;
            case EmailCampaignDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->emailCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->emailCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->emailCampaign)))->getShortName();
                break;
            case EmailCampaignUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->emailCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->emailCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->emailCampaign)))->getShortName();
                break;
            case ClientCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->client->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->client)))->getShortName();
                break;
            case ClientUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->client->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->client)))->getShortName();
                $auditEntry->previous_object_content = json_encode($event->client->getOriginal());
                break;
            case ClientCampaignDescriptionsCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->clientCampaignDescriptions->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->clientCampaignDescriptions)))->getShortName();
                break;
            case ClientCampaignDescriptionsUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->clientCampaignDescriptions->id;
                $auditEntry->previous_object_content = json_encode($event->clientCampaignDescriptions->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->clientCampaignDescriptions)))->getShortName();
                break;
            case ClientProgramsCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->clientsPrograms->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->clientsPrograms)))->getShortName();
                break;
            case ClientProgramsUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->clientsPrograms->id;
                $auditEntry->previous_object_content = json_encode($event->clientsPrograms->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->clientsPrograms)))->getShortName();
                break;
            case CommunicationCampaignsCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->communicationCampaign->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->communicationCampaign)))->getShortName();
                break;
            case CommunicationCampaignsDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->communicationCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->communicationCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->communicationCampaign)))->getShortName();
                break;
            case CommunicationCampaignsUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->communicationCampaign->id;
                $auditEntry->previous_object_content = json_encode($event->communicationCampaign->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->communicationCampaign)))->getShortName();
                break;
            case ModelReconciliationsDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->modelReconciliation->id;
                $auditEntry->previous_object_content = json_encode($event->modelReconciliation->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->modelReconciliation)))->getShortName();
                break;
            case ModelReconciliationsUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->modelReconciliation->id;
                $auditEntry->previous_object_content = json_encode($event->modelReconciliation->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->modelReconciliation)))->getShortName();
                break;
            case PatientCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->patient_id = $event->patient->_id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->patient)))->getShortName();
                break;
            case PatientDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->patient_id = $event->patient->_id;
                $auditEntry->previous_object_content = json_encode($event->patient->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->patient)))->getShortName();
                break;
            case PatientUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->patient_id = $event->patient->_id;
                $auditEntry->previous_object_content = json_encode($event->patient->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->patient)))->getShortName();
                break;
            case ProgramCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->program->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->program)))->getShortName();
                break;
            case ProgramUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->program->id;
                $auditEntry->previous_object_content = json_encode($event->program->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->program)))->getShortName();
                break;
            case ProgramEligibilityCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->participantProgramEligibility->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->participantProgramEligibility)))->getShortName();
                break;
            case ProgramEligibilityUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->participantProgramEligibility->id;
                $auditEntry->previous_object_content = json_encode($event->participantProgramEligibility->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->participantProgramEligibility)))->getShortName();
                break;
            case ProgramEligibilityDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->participantProgramEligibility->id;
                $auditEntry->previous_object_content = json_encode($event->participantProgramEligibility->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->participantProgramEligibility)))->getShortName();
                break;
            case ProgramEnrollmentCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->participantProgramEnrollment->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->participantProgramEnrollment)))->getShortName();
                break;
            case ProgramEnrollmentDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->participantProgramEnrollment->id;
                $auditEntry->previous_object_content = json_encode($event->participantProgramEnrollment->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->participantProgramEnrollment)))->getShortName();
                break;
            case ProgramEnrollmentUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->participantProgramEnrollment->id;
                $auditEntry->previous_object_content = json_encode($event->participantProgramEnrollment->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->participantProgramEnrollment)))->getShortName();
                break;
            case TaskCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->task->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->task)))->getShortName();
                break;
            case TaskDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->task->id;
                $auditEntry->previous_object_content = json_encode($event->task->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->task)))->getShortName();
                break;
            case TaskUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->task->id;
                $auditEntry->previous_object_content = json_encode($event->task->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->task)))->getShortName();
                break;
            case UserCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->user->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->user)))->getShortName();
                break;
            case UserDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->user->id;
                $auditEntry->previous_object_content = json_encode($event->user->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->user)))->getShortName();
                break;
            case UserUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->user->id;
                $auditEntry->previous_object_content = json_encode($event->user->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->user)))->getShortName();
                break;
            case PatientDiagnosesCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->patientDiagnoses->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->patientDiagnoses)))->getShortName();
                break;
            case PatientDiagnosesDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->patientDiagnoses->id;
                $auditEntry->previous_object_content = json_encode($event->patientDiagnoses->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->patientDiagnoses)))->getShortName();
                break;
            case PatientDiagnosesUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->patientDiagnoses->id;
                $auditEntry->previous_object_content = json_encode($event->patientDiagnoses->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->patientDiagnoses)))->getShortName();
                break;
            case CollaborativeMDAuditCreate::class:
                $auditEntry->change_type = AuditLog::OBJECT_CREATED;
                $auditEntry->object_id = $event->collaborativeMDAudit->id;
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->collaborativeMDAudit)))->getShortName();
                break;
            case CollaborativeMDAuditDelete::class:
                $auditEntry->change_type = AuditLog::OBJECT_DELETED;
                $auditEntry->object_id = $event->collaborativeMDAudit->id;
                $auditEntry->previous_object_content = json_encode($event->collaborativeMDAudit->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->collaborativeMDAudit)))->getShortName();
                break;
            case CollaborativeMDAuditUpdate::class:
                $auditEntry->change_type = AuditLog::OBJECT_UPDATED;
                $auditEntry->object_id = $event->collaborativeMDAudit->id;
                $auditEntry->previous_object_content = json_encode($event->collaborativeMDAudit->getOriginal());
                $auditEntry->object_changed = (new \ReflectionClass(get_class($event->collaborativeMDAudit)))->getShortName();
                break;
        }
        if(isset($auditEntry->change_type))
        {
            //if we do not know who made the change, default to daemon user
            if(!isset($auditEntry->changed_by))
            {
                $auditEntry->changed_by = $this->getDaemonUserId();
            }

            $auditEvent = new AuditLogEvent($auditEntry);
            $auditEvent->auditLog = $auditEvent->auditLog->toArray();

            $this->resolvedService->kafkaProducerQueue->push($this->getTopic(get_class($auditEvent)),
              new EventTransferModel(Event::getEnvConfig(),get_class($auditEvent), $auditEvent)
            );
        }
    }


    /**
     * @return integer|null
     */
    protected function getDaemonUserId()
    {
        $daemonUserId = User::where([
            'username' => $this->getTenantDaemonUserName(),
            'env_config' => config('database.connections.pgsql_tenant.schema')
        ])->pluck('id')->first();

        if(isset($daemonUserId))
        {
            return $daemonUserId;
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getTenantDaemonUserName()
    {
        return "daemonuser_" . config('database.connections.pgsql_tenant.schema');
    }

}