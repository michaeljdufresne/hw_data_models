<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 6/22/18
 * Time: 12:20 PM
 */

namespace Edumedics\DataModels\Eloquent;


use Illuminate\Database\Eloquent\Model;

class HealthwardViews extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'healthward_views';


    public function content(){
        return $this->hasMany('Edumedics\DataModels\Eloquent\EmbeddedHelpContent','view_id','id');
    }

    public function activeContent(){
        return $this->hasMany('Edumedics\DataModels\Eloquent\EmbeddedHelpContent','view_id','id')->active();
    }

}