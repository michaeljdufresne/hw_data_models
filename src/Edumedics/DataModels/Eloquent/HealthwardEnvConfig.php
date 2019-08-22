<?php


namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class HealthwardEnvConfig extends Model
{

    /**
     * @var string
     */
    protected $table = 'healthward_env_config_map';

    /**
     * @var string
     */
    protected $connection = 'pgsql';


    /**
     * @var array
     */
    protected $fillable = ['default_email_signature','company_phone_number','company_hours_of_operation',
        'tenant_logo_small','tenant_logo_medium','tenant_logo_large','mail_driver','mail_host',
        'mail_port','mail_username','mail_password', 'tenant_domain'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logoSmall()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Document', 'id', 'tenant_logo_small');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logoMedium()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Document', 'id', 'tenant_logo_medium');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logoLarge()
    {
        return $this->hasOne('Edumedics\DataModels\Eloquent\Document', 'id', 'tenant_logo_large');
    }

}