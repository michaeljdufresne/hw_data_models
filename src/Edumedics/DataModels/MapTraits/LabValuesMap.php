<?php

namespace Edumedics\DataModels\MapTraits;

trait LabValuesMap
{
    // TODO remove
    protected $unitsArray = [
        "1558-6" => 'mg/dL',
        "2345-7" => 'mg/dL',
        "14995-5" => 'mg/dL',
        "2093-3" => 'mg/dL',
        "13457-7" => 'mg/dL',
        "2085-9" => 'mg/dL',
        "3043-7" => 'mg/dL',
        "4548-4" => '%'
    ];

    protected $loinc_to_value_name = [
        "1558-6" => "glucose",
        "1521-4" => "glucose",
        "2345-7" => "glucose",
        "10449-7" => "glucose",
        "10450-5" => "glucose",
        "10832-4" => "glucose",
        "14770-2" => "glucose",
        "14995-5" => "glucose",
        "75864-9" => "glucose",
        "74774-1" => "glucose",
        "30265-3" => "glucose",
        "1492-8" => "glucose",
        "1494-4" => "glucose",
        "55351-1" => "glucose",
        "1496-9" => "glucose",
        "40286-7" => "glucose",
        "1499-3" => "glucose",
        "14753-8" => "glucose",
        "1501-6" => "glucose",
        "14754-6" => "glucose",
        "1504-0" => "glucose",
        "51597-3" => "glucose",
        "1507-3" => "glucose",
        "20438-8" => "glucose",
        "14756-1" => "glucose",
        "30267-9" => "glucose",
        "9375-7" => "glucose",
        "55381-8" => "glucose",
        "6749-6" => "glucose",
        "26554-6" => "glucose",
        "25666-9" => "glucose",
        "30251-3" => "glucose",
        "14757-9" => "glucose",
        "1514-9" => "glucose",
        "41024-1" => "glucose",
        "1518-0" => "glucose",
        "20436-2" => "glucose",
        "49134-0" => "glucose",
        "14759-5" => "glucose",
        "14764-5" => "glucose",
        "1530-5" => "glucose",
        "32320-4" => "glucose",
        "1533-9" => "glucose",
        "20437-0" => "glucose",
        "14765-2" => "glucose",
        "40285-9" => "glucose",
        "11032-0" => "glucose",
        "11142-7" => "glucose",
        "11143-5" => "glucose",
        "1554-5" => "glucose",
        "17865-7" => "glucose",
        "1557-8" => "glucose",
        "14771-0" => "glucose",
        "2093-3" => "total_cholesterol",
        "13457-7" => "ldl",
        "11054-4" => "ldl",
        "12773-8" => "ldl",
        "13459-3" => "ldl",
        "2085-9" => "hdl",
        "12771-2" => "hdl",
        "12772-0" => "hdl",
        "14646-4" => "hdl",
        "3043-7" => "triglycerides",
        "12228-3" => "triglycerides",
        "12951-0" => "triglycerides",
        "4548-4" => "a1c",
        "17855-8" => "a1c",
        "41995-2" => "a1c",
        "55454-3" => "a1c",
        "69405-9" => "egfr",
        "2160-0" => "creatinine",
        "2161-8" => "creatinine",
        "14682-9" => "creatinine",
        "38483-4" => "creatinine",
        "3094-0" => "bun",
        "6299-2" => "bun",
        "14937-7" => "bun",
        "3097-3" => "bun"
    ];

    protected $loinc_to_value_name_glucose_status = [
        "1558-6" => "glucose_fasting",
        "1521-4" => "glucose_non_fasting",
        "2345-7" => "glucose_fasting",
        "10449-7" => "glucose_non_fasting",
        "10450-5" => "glucose_fasting",
        "10832-4" => "glucose_non_fasting",
        "14770-2" => "glucose_fasting",
        "14995-5" => "glucose_non_fasting",
        "75864-9" => "glucose_non_fasting",
        "74774-1" => "glucose_non_fasting",
        "30265-3" => "glucose_non_fasting",
        "1492-8" => "glucose_non_fasting",
        "1494-4" => "glucose_non_fasting",
        "55351-1" => "glucose_non_fasting",
        "1496-9" => "glucose_non_fasting",
        "40286-7" => "glucose_non_fasting",
        "1499-3" => "glucose_non_fasting",
        "14753-8" => "glucose_non_fasting",
        "1501-6" => "glucose_non_fasting",
        "14754-6" => "glucose_non_fasting",
        "1504-0" => "glucose_non_fasting",
        "51597-3" => "glucose_non_fasting",
        "1507-3" => "glucose_non_fasting",
        "20438-8" => "glucose_non_fasting",
        "14756-1" => "glucose_non_fasting",
        "30267-9" => "glucose_non_fasting",
        "9375-7" => "glucose_non_fasting",
        "55381-8" => "glucose_non_fasting",
        "6749-6" => "glucose_non_fasting",
        "26554-6" => "glucose_non_fasting",
        "25666-9" => "glucose_non_fasting",
        "30251-3" => "glucose_non_fasting",
        "14757-9" => "glucose_non_fasting",
        "1514-9" => "glucose_non_fasting",
        "41024-1" => "glucose_non_fasting",
        "1518-0" => "glucose_non_fasting",
        "20436-2" => "glucose_non_fasting",
        "49134-0" => "glucose_non_fasting",
        "14759-5" => "glucose_non_fasting",
        "14764-5" => "glucose_non_fasting",
        "1530-5" => "glucose_non_fasting",
        "32320-4" => "glucose_non_fasting",
        "1533-9" => "glucose_non_fasting",
        "20437-0" => "glucose_non_fasting",
        "14765-2" => "glucose_non_fasting",
        "40285-9" => "glucose_non_fasting",
        "11032-0" => "glucose_non_fasting",
        "11142-7" => "glucose_non_fasting",
        "11143-5" => "glucose_non_fasting",
        "1554-5" => "glucose_fasting",
        "17865-7" => "glucose_fasting",
        "1557-8" => "glucose_fasting",
        "14771-0" => "glucose_fasting",
        "2093-3" => "total_cholesterol",
        "13457-7" => "ldl",
        "11054-4" => "ldl",
        "12773-8" => "ldl",
        "13459-3" => "ldl",
        "2085-9" => "hdl",
        "12771-2" => "hdl",
        "12772-0" => "hdl",
        "14646-4" => "hdl",
        "3043-7" => "triglycerides",
        "12228-3" => "triglycerides",
        "12951-0" => "triglycerides",
        "4548-4" => "a1c",
        "17855-8" => "a1c",
        "41995-2" => "a1c",
        "55454-3" => "a1c",
        "69405-9" => "egfr",
        "2160-0" => "creatinine",
        "2161-8" => "creatinine",
        "14682-9" => "creatinine",
        "38483-4" => "creatinine",
        "3094-0" => "bun",
        "6299-2" => "bun",
        "14937-7" => "bun",
        "3097-3" => "bun"
    ];

    protected $glucoseLoincs = [
        "1558-6", "2345-7", "10449-7", "10450-5", "10832-4", "14770-2",
    ];

    protected $tcLoincs = [
        "2093-3"
    ];

    protected $ldlLoincs = [
        "13457-7", "11054-4", "12773-8", "13459-3"
    ];

    protected $hdlLoincs = [
        "2085-9", "12771-2", "12772-0", "14646-4",
    ];

    protected $triglyceridesLoincs = [
        "3043-7", "12228-3", "12951-0"
    ];

    protected $a1cLoincs = [
        "4548-4", "17855-8", "41995-2", "55454-3"
    ];

    protected function getCopdStageField()
    {
        return env('APP_ENV') == 'prod' ? 65770664 : 74914464;
    }

    protected function getPHQ9ScoreField()
    {
        return env('APP_ENV') == 'prod' ? 65768804 : 74913872;
    }
}