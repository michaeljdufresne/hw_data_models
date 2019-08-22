<?php

namespace Edumedics\DataModels\Traits;

use Edumedics\DataModels\Aggregate\Patient;
use Edumedics\DataModels\Eloquent\FlaggedDuplicatePatients;
use Illuminate\Support\Facades\Log;

trait PatientDuplicationRulesTrait
{
    use NicknamesLookupTrait;

    /**
     * @var
     */
    protected $possibleDuplicates;

    /**
     * @var
     */
    protected $firstNameCleansed;

    /**
     * @var
     */
    protected $lastNameCleansed;

    /**
     * @var
     */
    protected $possibleNicknames;

    /**
     * @var
     */
    protected $nicknameLookup;

    /**
     * @var
     */
    protected $strictLookup; // false and it will run rules that not necessarily match on DOB

    /**
     * @param Patient $patient
     * @param null $lookup
     * @param bool $strict_lookup
     * @return array
     */
    protected function runRules(Patient $patient, $lookup = null, $strict_lookup = true){

        $this->nicknameLookup = $lookup;
        $this->strictLookup = $strict_lookup;

        $this->possibleDuplicates = [];
        $this->firstNameCleansed = null;
        $this->lastNameCleansed = null;
        $this->possibleNicknames = [];

        $this->ruleOne($patient);
        $this->ruleTwo($patient);
        $this->ruleThree($patient);
        $this->ruleFour($patient);
        $this->ruleFive($patient);
        $this->ruleSix($patient);
        $this->ruleSeven($patient);
        $this->ruleEight($patient);

        $results = $this->cleanResults();

        $this->flagPatients($patient->_id, $results);

        return $results;
    }

    /**
     * @return array
     */
    protected function cleanResults(){
        $result = [];

        foreach ($this->possibleDuplicates as $rule => $ids){
            foreach ($ids as $id){
                if(!in_array($id,$result)){
                    array_push($result,$id);
                }
            }
        }

        return $result;
    }

    protected function flagPatients($primary_patient_id, $duplicates_patient_ids){

        foreach ($duplicates_patient_ids as $duplicate_patient_id){
            $flaggedPatient = FlaggedDuplicatePatients::where('primary_patient_id', $primary_patient_id)
                ->where('duplicate_patient_id',$duplicate_patient_id)->first();

            if(!isset($flaggedPatient)){
                $flagPatient = new FlaggedDuplicatePatients();
                $flagPatient->primary_patient_id = $primary_patient_id;
                $flagPatient->duplicate_patient_id = $duplicate_patient_id;
                $flagPatient->save();
            }

            $flaggedPatient = FlaggedDuplicatePatients::where('primary_patient_id', $duplicate_patient_id)
                ->where('duplicate_patient_id',$primary_patient_id)->first();

            if(!isset($flaggedPatient)){
                $flagPatient = new FlaggedDuplicatePatients();
                $flagPatient->primary_patient_id = $duplicate_patient_id;
                $flagPatient->duplicate_patient_id = $primary_patient_id;
                $flagPatient->save();
            }
        }
        $this->handleMissingDuplicatePatients($primary_patient_id, $duplicates_patient_ids);
    }

    protected function handleMissingDuplicatePatients($primary_patient_id, $duplicate_patient_ids){
        $allDuplicatesStored = FlaggedDuplicatePatients::where('primary_patient_id', $primary_patient_id)->get();

        foreach ($allDuplicatesStored as $duplicateStored){
            if(!in_array($duplicateStored->duplicate_patient_id,$duplicate_patient_ids)){

                $inverseDuplicateEntry = FlaggedDuplicatePatients::where('primary_patient_id',$duplicateStored->duplicate_patient_id)
                    ->where('duplicate_patient_id',$primary_patient_id)->first();
                if(isset($inverseDuplicateEntry)){
                    $inverseDuplicateEntry->delete();
                }
                $duplicateStored->delete();
            }
        }
    }


    /**
     * @param Patient $patient
     */
    protected function ruleOne(Patient $patient){
        /* Duplicate Rule 1:
         * If first_name, last_name, and DOB match exactly, then mark as a duplicate
         */

        $duplicates = Patient::where('first_name', $patient->first_name)
            ->where('last_name', $patient->last_name)
            ->where('date_of_birth', $patient->date_of_birth)
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }
            $this->possibleDuplicates['rule_one'] = $duplicates;
        }

        $this->ruleOne_versionTwo($patient);
    }

    /**
     * @param Patient $patient
     */
    protected function ruleOne_versionTwo(Patient $patient){
        /* Duplicate Rule 1 v2:
         * If first_name matches with nick_name or middle_name, last_name matches with a maiden_name or last_name
         * and DOB match exactly, then mark as a duplicate
         */
        $duplicates = Patient::where(function ($query) use ($patient) {
            $query->where('nick_name', $patient->first_name)
                ->orWhere('middle_name', $patient->first_name);
        })
            ->where(function ($query) use ($patient) {
                $query->where('last_name', $patient->last_name)
                    ->orWhere('maiden_name', $patient->last_name);
            })
            ->where('date_of_birth', $patient->date_of_birth)
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }

            $this->possibleDuplicates['rule_one_v2'] = $duplicates;
        }
    }

    /**
     * @param Patient $patient
     */
    protected function ruleTwo(Patient $patient){
        /* Duplicate Rule 2:
         * If first_name, last_name, and inverseDOB (MONTH<->DAY) match, then mark as a duplicate
         */
        if($patient->date_of_birth){
            $day = $patient->date_of_birth->format('d');
            $month = $patient->date_of_birth->format('m');
            $year = $patient->date_of_birth->format('Y');

            if($day <= 12){
                $inverseDOB = new \DateTime($year.'-'.$day.'-'.$month);
                $duplicates = Patient::where('first_name', $patient->first_name)
                    ->where('last_name', $patient->last_name)
                    ->where('gender', $patient->gender)
                    ->where('date_of_birth', $inverseDOB)
                    ->pluck('_id')->toArray();

                if(!empty($duplicates)){
                    // Flag Patient
                    //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
                    $keys = array_keys($duplicates, $patient->_id);
                    foreach ($keys as $key){
                        // Remove the patient we are testing with
                        unset($duplicates[$key]);
                    }

                    $this->possibleDuplicates['rule_two'] = $duplicates;
                }
            }

            $this->ruleTwo_versionTwo($patient);
        }
    }

    /**
     * @param Patient $patient
     */
    protected function ruleTwo_versionTwo(Patient $patient){
        /* Duplicate Rule 2 v2:
         * If first_name matches with nick_name or middle_name, last_name matches with a maiden_name or last_name
         * and inverseDOB (MONTH<->DAY) match, then mark as a duplicate
         */
        if($patient->date_of_birth) {
            $day = $patient->date_of_birth->format('d');
            $month = $patient->date_of_birth->format('m');
            $year = $patient->date_of_birth->format('Y');

            if($day <= 12){
                $inverseDOB = new \DateTime($year.'-'.$day.'-'.$month);
                $duplicates = Patient::where(function ($query) use ($patient) {
                    $query->where('nick_name', $patient->first_name)
                        ->orWhere('middle_name', $patient->first_name);
                })
                    ->where(function ($query) use ($patient) {
                        $query->where('last_name', $patient->last_name)
                            ->orWhere('maiden_name', $patient->last_name);
                    })
                    ->where('date_of_birth', $inverseDOB)
                    ->pluck('_id')->toArray();

                if(!empty($duplicates)){
                    // Flag Patient
                    //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
                    $keys = array_keys($duplicates, $patient->_id);
                    foreach ($keys as $key){
                        // Remove the patient we are testing with
                        unset($duplicates[$key]);
                    }

                    $this->possibleDuplicates['rule_two_v2'] = $duplicates;
                }
            }
        }
    }

    /**
     * @param Patient $patient
     */
    protected function ruleThree(Patient $patient){
        /* Duplicate Rule 3 Combined with Rule 5:
         * On first_name and last_name, convert Alphanumeric characters to dashes and split into array
         * If firstNameCleansed, lastNameCleansed, and DOB match exactly, then mark as a duplicate
         */

        $first_name_array = array_filter(explode('-', preg_replace("/[^A-Za-z]/", '-', $patient->first_name)));
        $last_name_array = array_filter(explode('-', preg_replace("/[^A-Za-z]/", '-', $patient->last_name)));

        $this->firstNameCleansed = $first_name_array;
        $this->lastNameCleansed = $last_name_array;

        $duplicates = Patient::whereIn('first_name', $this->firstNameCleansed)
            ->whereIn('last_name', $this->lastNameCleansed)
            ->where('date_of_birth', $patient->date_of_birth)
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }

            $this->possibleDuplicates['rule_three'] = $duplicates;
        }
        $this->ruleThree_versionTwo($patient);
    }

    /**
     * @param Patient $patient
     */
    protected function ruleThree_versionTwo(Patient $patient){
        /* Duplicate Rule 3 Combined with Rule 5 v2:
         * If first_name_cleansed matches with nick_name or middle_name, last_name_cleansed matches with a maiden_name or last_name
         * and DOB match exactly, then mark as a duplicate
         */

        $duplicates = Patient::where(function ($query) use ($patient) {
            $query->whereIn('middle_name', $this->firstNameCleansed)
                ->orWhereIn('nick_name', $this->firstNameCleansed);
        })
            ->where(function ($query) use ($patient) {
                $query->whereIn('last_name', $this->lastNameCleansed)
                    ->orWhereIn('maiden_name', $this->lastNameCleansed);
            })
            ->where('date_of_birth', $patient->date_of_birth)
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }

            $this->possibleDuplicates['rule_three_v2'] = $duplicates;
        }

    }

    /**
     * @param Patient $patient
     */
    protected function ruleFour(Patient $patient){
        /* Duplicate Rule 4:
         * Nickname lookup as first_name
         * If first_name_nickname, last_name_cleansed, DOB match exactly, then mark as a duplicate
         *
         * List of Nicknames:       https://github.com/carltonnorthern/nickname-and-diminutive-names-lookup/blob/master/names.csv
         * List of Last Names:      https://www2.census.gov/topics/genealogy/1990surnames/dist.all.last
         * List of Names (Female and Male): https://www.census.gov/topics/population/genealogy/data/1990_census/1990_census_namefiles.html
         */
        $first_name = $patient->first_name;
        if($this->nicknameLookup == 1){
            // ARRAY LOOKUP
            $this->possibleNicknames = $this->nicknameArrayLookup($first_name);
            if(count($this->possibleNicknames) > 0){
                $duplicates = Patient::whereIn('first_name', $this->possibleNicknames)
                    ->where(function ($query) use ($patient) {
                        $query->whereIn('last_name', $this->lastNameCleansed)
                            ->orWhereIn('maiden_name', $this->lastNameCleansed);
                    })
                    ->where('date_of_birth', $patient->date_of_birth)
                    ->pluck('_id')->toArray();

                if(!empty($duplicates)){
                    // Flag Patient
                    //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
                    $keys = array_keys($duplicates, $patient->_id);
                    foreach ($keys as $key){
                        // Remove the patient we are testing with
                        unset($duplicates[$key]);
                    }

                    $this->possibleDuplicates['rule_four_array'] = $duplicates;
                }
            }
        }
        if($this->nicknameLookup == 2){
            // REDIS LOOKUP
            $this->possibleNicknames = $this->nicknameRedisLookup($first_name);
            if(count($this->possibleNicknames) > 0){
                $duplicates = Patient::whereIn('first_name', $this->possibleNicknames)
                    ->where(function ($query) use ($patient) {
                        $query->whereIn('last_name', $this->lastNameCleansed)
                            ->orWhereIn('maiden_name', $this->lastNameCleansed);
                    })
                    ->where('date_of_birth', $patient->date_of_birth)
                    ->pluck('_id')->toArray();

                if(!empty($duplicates)){
                    // Flag Patient
                    //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
                    $keys = array_keys($duplicates, $patient->_id);
                    foreach ($keys as $key){
                        // Remove the patient we are testing with
                        unset($duplicates[$key]);
                    }

                    $this->possibleDuplicates['rule_four_redis'] = $duplicates;
                }
            }
        }
    }

    /**
     * @param Patient $patient
     */
    protected function ruleFive(Patient $patient){
        /* Duplicate Rule 5:
         * Match Nicknames with First name and Last Name matched based on substrings
         * If first_name_nickname, last_name like last_name_cleansed, DOB match exactly, then mark as a duplicate
         */

        if(count($this->possibleNicknames) > 0){
            $duplicates = Patient::whereIn('first_name', $this->possibleNicknames)
                ->where(function ($query) use ($patient) {
                    $query->where( function ($query) use ($patient){
                        foreach ($this->lastNameCleansed as $last_name){
                            $query->orWhere('last_name', 'LIKE', '%'.$last_name.'%');
                        }
                    })->orWhere(function ($query) use ($patient) {
                        foreach ($this->lastNameCleansed as $last_name){
                            $query->orWhere('maiden_name', 'LIKE', '%'.$last_name.'%');
                        }
                    });
                })
                ->where('date_of_birth', $patient->date_of_birth)
                ->pluck('_id')->toArray();

            if(!empty($duplicates)){
                // Flag Patient
                //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
                $keys = array_keys($duplicates, $patient->_id);
                foreach ($keys as $key){
                    // Remove the patient we are testing with
                    unset($duplicates[$key]);
                }

                $this->possibleDuplicates['rule_five'] = $duplicates;
            }
        }

    }

    /**
     * @param Patient $patient
     */
    protected function ruleSix(Patient $patient){
        /* Duplicate Rule 6:
         * If first name cleansed match with first_name, nick_name or middle_name, last name cleansed match with last_name or maiden_name,
         * birth year and birth month, but not the specific day mark as duplicate
         */

        if($patient->date_of_birth){
            $day = $patient->date_of_birth->format('d');
            $month = $patient->date_of_birth->format('m');
            $year = $patient->date_of_birth->format('Y');


            $duplicates = Patient::where(function ($query) use ($patient) {
                $query->whereIn('first_name', $this->firstNameCleansed)
                    ->orWhereIn('nick_name', $this->firstNameCleansed)
                    ->orWhereIn('middle_name', $this->firstNameCleansed);
                })
                ->where(function ($query) use ($patient) {
                    $query->whereIn('last_name', $this->lastNameCleansed)
                        ->orWhereIn('maiden_name', $this->lastNameCleansed);
                })
                ->whereMonth('date_of_birth', $month)
                ->whereYear('date_of_birth', $year)->pluck('_id')->toArray();
            if(!empty($duplicates)){
                // Flag Patient
                //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
                $keys = array_keys($duplicates, $patient->_id);
                foreach ($keys as $key){
                    // Remove the patient we are testing with
                    unset($duplicates[$key]);
                }

                $this->possibleDuplicates['rule_six'] = $duplicates;
            }
            if(!$this->strictLookup){
                $this->ruleSix_versionTwo($patient);
            }
        }
    }

    /**
     * @param Patient $patient
     */
    protected function ruleSix_versionTwo(Patient $patient){
        /* Duplicate Rule 6 v.2:
         * If first name cleansed match with first_name, nick_name or middle_name, last name cleansed match with last_name or maiden_name,
         * then mark as a duplicate, this rule doesn't include DOB
         */
        $duplicates = Patient::where(function ($query) use ($patient) {
            $query->whereIn('first_name', $this->firstNameCleansed)
                ->orWhereIn('nick_name', $this->firstNameCleansed)
                ->orWhereIn('middle_name', $this->firstNameCleansed);
        })
            ->where(function ($query) use ($patient) {
                $query->whereIn('last_name', $this->lastNameCleansed)
                    ->orWhereIn('maiden_name', $this->lastNameCleansed);
            })
            ->pluck('_id')->toArray();

        if(!empty($duplicates)) {
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key) {
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }

            $this->possibleDuplicates['rule_six_v2'] = $duplicates;
        }
    }

    /**
     * @param Patient $patient
     */
    protected function ruleSeven(Patient $patient){
        /* Duplicate Rule 7
         * Match based upon a substring, rather than exact match
         * If first name cleansed like nick name, first name or middle_name, and last name cleansed like maiden name or last name
         * and exact DOB then mark as duplicate
         */
        $duplicates = Patient::where(function ($query) use ($patient) {
            $query->where( function ($query) use ($patient){
                foreach ($this->firstNameCleansed as $name){
                    $query->orWhere('first_name', 'LIKE', '%'.$name.'%');
                }
            })->orWhere(function ($query) use ($patient) {
                foreach ($this->firstNameCleansed as $name){
                    $query->orWhere('nick_name', 'LIKE', '%'.$name.'%');
                }
            })->orWhere(function ($query) use ($patient) {
                foreach ($this->firstNameCleansed as $name){
                    $query->orWhere('middle_name', 'LIKE', '%'.$name.'%');
                };
            });
        })->where(function ($query) use ($patient) {
                $query->where( function ($query) use ($patient){
                    foreach ($this->lastNameCleansed as $last_name){
                        $query->orWhere('last_name', 'LIKE', '%'.$last_name.'%');
                    }
                })->orWhere(function ($query) use ($patient) {
                    foreach ($this->lastNameCleansed as $last_name){
                        $query->orWhere('maiden_name', 'LIKE', '%'.$last_name.'%');
                    }
                });
            })
            ->where('date_of_birth', $patient->date_of_birth)
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }

            $this->possibleDuplicates['rule_seven'] = $duplicates;
        }
        if(!$this->strictLookup){
            $this->ruleSeven_versionTwo($patient);
        }
    }

    /**
     * @param Patient $patient
     */
    protected function ruleSeven_versionTwo(Patient $patient){
        /* Duplicate Rule 7 v2:
         * Match based upon a substring, rather than exact match with no DOB
         * If first name cleansed like nick name, middle_name or first name,
         * and last name cleansed like maiden name or last name
         * then mark as duplicate
         */
        $duplicates = Patient::where(function ($query) use ($patient) {
            $query->where( function ($query) use ($patient){
                foreach ($this->firstNameCleansed as $name){
                    $query->orWhere('first_name', 'LIKE', '%'.$name.'%');
                }
            })->orWhere(function ($query) use ($patient) {
                foreach ($this->firstNameCleansed as $name){
                    $query->orWhere('nick_name', 'LIKE', '%'.$name.'%');
                }
            })->orWhere(function ($query) use ($patient) {
                foreach ($this->firstNameCleansed as $name){
                    $query->orWhere('middle_name', 'LIKE', '%'.$name.'%');
                };
            });
        })->where(function ($query) use ($patient) {
                $query->where( function ($query) use ($patient){
                    foreach ($this->lastNameCleansed as $last_name){
                        $query->orWhere('last_name', 'LIKE', '%'.$last_name.'%');
                    }
                })->orWhere(function ($query) use ($patient) {
                    foreach ($this->lastNameCleansed as $last_name){
                        $query->orWhere('maiden_name', 'LIKE', '%'.$last_name.'%');
                    }
                });
            })
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }

            $this->possibleDuplicates['rule_seven_v2'] = $duplicates;
        }

    }

    /**
     * @param Patient $patient
     */
    protected function ruleEight(Patient $patient){
        /* Duplicate Rule 8:
         * same Dob, same last name, but a different first name
         * If last_name and  DOB match exactly then mark as duplicate
         */
        $duplicates = Patient::where('last_name', $patient->last_name)
            ->where('date_of_birth', $patient->date_of_birth)
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }
            $this->possibleDuplicates['rule_eight'] = $duplicates;
        }
        $this->ruleEight_versionTwo($patient);

    }

    /**
     * @param Patient $patient
     */
    protected function ruleEight_versionTwo(Patient $patient){
        /* Duplicate Rule 8:
         * same Dob, same last name, but a different first name
         * If last_name_cleansed and  DOB match exactly then mark as duplicate
         */
        $duplicates = Patient::where(function ($query) use ($patient) {
            $query->whereIn('last_name', $this->lastNameCleansed)
                ->orWhereIn('maiden_name', $this->lastNameCleansed);
        })
            ->where('date_of_birth', $patient->date_of_birth)
            ->pluck('_id')->toArray();

        if(!empty($duplicates)){
            // Flag Patient
            //$this->possibleDuplicates = array_merge($this->possibleDuplicates,$duplicates);
            $keys = array_keys($duplicates, $patient->_id);
            foreach ($keys as $key){
                // Remove the patient we are testing with
                unset($duplicates[$key]);
            }
            $this->possibleDuplicates['rule_eight_v2'] = $duplicates;
        }
    }

}
