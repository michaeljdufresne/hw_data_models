<?php

namespace Edumedics\DataModels\Eloquent;

use Illuminate\Database\Eloquent\Model;

class UserSecurity extends Model {

    /**
     * @var string
     */
    protected $connection = 'pgsql';

    /**
     * @var string
     */
    protected $table = 'user_security_questions';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'security_question', 'security_answer'];

    /**
     * @var array
     */
    public static $securityQuestions = [
        1 => 'What was your childhood nickname?',
        2 => 'In what city did you meet your spouse/significant other?',
        3 => 'What is the name of your favorite childhood friend?',
        4 => 'What street did you live on in third grade?',
        5 => 'What is your oldest sibling’s birthday month and year? (e.g., January 1900)',
        6 => 'What is the middle name of your oldest child?',
        7 => 'What school did you attend for sixth grade?',
        8 => 'What was the name of your first stuffed animal?',
        9 => 'In what city or town did your mother and father meet?',
        10 => 'In what city does your nearest sibling live?'
    ];

}