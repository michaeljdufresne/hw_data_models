<?php

namespace Edumedics\DataModels\Eloquent\Reporting;

use Illuminate\Database\Eloquent\Model;

class ExecutiveReportAppointments extends Model
{

    protected $connection = 'pgsql_reporting';

    protected $table = 'executive_report_appointments';
}