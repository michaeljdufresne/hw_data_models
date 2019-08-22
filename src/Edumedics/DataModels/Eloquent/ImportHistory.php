<?php

namespace Edumedics\DataModels\Eloquent;

use Edumedics\DataModels\Scopes\OmitArchivedScope;
use Illuminate\Database\Eloquent\Model;

class ImportHistory extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql_tenant';

    /**
     * @var string
     */
    protected $table = 'import_history';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'client_id', 'import_type', 'is_rollback', 'rollback_user_id'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OmitArchivedScope());
    }

    /**
     *
     */
    public function archive()
    {
        $this->archived = true;
        $this->save();
    }

    /**
     *
     */
    public function unarchive()
    {
        $this->archived = false;
        $this->save();
    }
}