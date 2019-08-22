<?php

namespace Edumedics\DataModels\Traits;

use Edumedics\DataModels\Dto\Common\ExternalIdDto;
use Edumedics\DataModels\Eloquent\HealthwardEnvConfig;
use Edumedics\DataModels\Eloquent\PatientIdMap;
use Edumedics\DataModels\Eloquent\User;
use Edumedics\DataModels\Eloquent\UsersApiToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait TenantConnectorTrait
{

    /**
     * Switch the Tenant connection to a different environment config.
     * @return void
     * @throws
     */
    public function reconnect()
    {
        if (empty(session('env_config')))
        {
            session(['env_config' => Auth::user()->env_config]);
        }

        DB::purge('pgsql_tenant');
        config(['database.connections.pgsql_tenant.schema' => session('env_config')]);
        DB::reconnect('pgsql_tenant');
        Schema::connection('pgsql_tenant')->getConnection()->reconnect();
    }

    /**
     * @param $envConfig
     */
    protected function setTenantConnection($envConfig)
    {
        DB::purge('pgsql_tenant');
        config(['database.connections.pgsql_tenant.schema' => $envConfig]);
        DB::reconnect('pgsql_tenant');
        Schema::connection('pgsql_tenant')->getConnection()->reconnect();
    }

    /**
     * @param $user
     */
    public function setTenantForUser($user)
    {
        DB::purge('pgsql_tenant');
        session(['env_config' => $user->env_config]);
        config(['database.connections.pgsql_tenant.schema' => $user->env_config]);
        DB::reconnect('pgsql_tenant');
    }

    /**
     * @param HealthwardEnvConfig $tenantConfig
     */
    public function setTenantforOperation(HealthwardEnvConfig $tenantConfig)
    {
        DB::purge('pgsql_tenant');
        config(['database.connections.pgsql_tenant.schema' => $tenantConfig->env_config]);
        DB::reconnect('pgsql_tenant');
    }

    /**
     * @param UsersApiToken $usersApiToken
     * @throws \Exception
     */
    public function setTenantByUsersApiToken(UsersApiToken $usersApiToken)
    {
        $user = User::where('id', $usersApiToken->user_id)->first();
        if (!isset($user))
        {
            throw new \Exception('Unable to find user for configuring tenant DB');
        }
        DB::purge('pgsql_tenant');
        config(['database.connections.pgsql_tenant.schema' => $user->env_config]);
        DB::reconnect('pgsql_tenant');
    }


    /**
     * @param $id
     * @param int $type
     */
    public function findTenantForOperation($id, $type = ExternalIdDto::DrChronoId)
    {
        //DrChrono Patient Id
        if ($type == ExternalIdDto::DrChronoId)
        {
            $patientIdMap = PatientIdMap::where('drchrono_patient_id', $id)->first();
            if (isset($patientIdMap))
            {
                DB::purge('pgsql_tenant');
                config(['database.connections.pgsql_tenant.schema' => $patientIdMap->env_config]);
                DB::reconnect('pgsql_tenant');
                return;
            }
        }
        elseif ($type == ExternalIdDto::ViiMedPersonId)
        {
            $patientIdMap = PatientIdMap::where('viimed_person_id', $id)->first();
            if (isset($patientIdMap))
            {
                DB::purge('pgsql_tenant');
                config(['database.connections.pgsql_tenant.schema' => $patientIdMap->env_config]);
                DB::reconnect('pgsql_tenant');
                return;
            }
        }
        elseif ($type == ExternalIdDto::EmVitalsBcid)
        {
            $patientIdMap = PatientIdMap::where('emvitals_bcid', $id)->first();
            if (isset($patientIdMap))
            {
                DB::purge('pgsql_tenant');
                config(['database.connections.pgsql_tenant.schema' => $patientIdMap->env_config]);
                DB::reconnect('pgsql_tenant');
                return;
            }
        }
        elseif ($type == ExternalIdDto::EClinicalWorksId)
        {
            DB::purge('pgsql_tenant');
            config(['database.connections.pgsql_tenant.schema' => 'sentry_health']);
            DB::reconnect('pgsql_tenant');
            return;
        }

        DB::purge('pgsql_tenant');
        config(['database.connections.pgsql_tenant.schema' => 'sentry_health']);
        DB::reconnect('pgsql_tenant');
    }

    /**
     * @param HealthwardEnvConfig $tenantConfig
     * @param array $methodSignature
     * @param array $args
     */
    public function runCommandForTenant(HealthwardEnvConfig $tenantConfig, array $methodSignature, array $args)
    {

    }

    /**
     * @param HealthwardEnvConfig $tenantConfig
     */
    public function runMigrationForTenant(HealthwardEnvConfig $tenantConfig)
    {
        $this->input->setOption('database', 'pgsql_tenant');
        $this->comment("\nSchema: " . $tenantConfig->env_config);
        $this->setTenantforOperation($tenantConfig);
        parent::handle();
    }

    /**
     * @param string $envConfigs
     * @return mixed
     */
    public function getConfigsFromList(string $envConfigs)
    {
        $configs = array_map('trim', explode(',', $envConfigs));
        return HealthwardEnvConfig::whereIn('env_config', $configs)->get();
    }

}
