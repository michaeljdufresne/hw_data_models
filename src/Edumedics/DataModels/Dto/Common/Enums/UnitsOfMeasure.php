<?php
/**
 * Created by IntelliJ IDEA.
 * User: marthahidalgo
 * Date: 8/1/19
 * Time: 12:20 PM
 */

namespace Edumedics\DataModels\Dto\Common\Enums;


/**
 * Class UnitsOfMeasure
 * @package Edumedics\DataModels\Dto\Enums
 */
class UnitsOfMeasure
{
    const __default = 0,
        Femtoliters = 1,
        Grams = 2,
        GramsPerDeciliter = 3,
        GramsPerLiter = 4,
        InternationalUnitsPerLiter = 5,
        InternationalUnitsPerMilliliter = 6,
        Micrograms = 7,
        MicrogramsPerDeciliter = 8,
        MicrogramsPerLiter = 9,
        MicrokatalsPerLiter = 10,
        Microliters = 11,
        MicromolesPerLiter = 12,
        Milliequivalents = 13,
        MilliequivalentsPerLiter = 14,
        Milligrams = 15,
        MilligramsPerDeciliter = 16,
        MilligramsPerLiter = 17,
        MilliInternationalUnitsPerLiter = 18,
        Milliliters = 19,
        Millimeters = 20,
        MillimetersOfMercury = 21,
        Millimoles = 22,
        MillimolesPerLiter = 23,
        MilliosmolesPerKilogramOfWater = 24,
        MilliunitsPerGram = 25,
        MilliunitsPerLiter = 26,
        NanogramsPerDeciliter = 27,
        NanogramsPerLiter = 28,
        NanogramsPerMilliliter = 29,
        NanogramsPerMilliliterPerHour = 30,
        Nanomoles = 31,
        NanomolesPerLiter = 32,
        Picograms = 33,
        PicogramsPerMilliliter = 34,
        PicomolesPerLiter = 35,
        Titers = 36,
        UnitsPerLiter = 37,
        UnitsPerMilliliter = 38,
        Kilogram = 39,
        Pound = 40,
        Meter = 41,
        Centimeter = 42,
        Inch = 43,
        Foot = 44,
        Liter =  45,
        CentimeterOfWater = 46,
        Pascal = 47,
        Atmosphere = 48,
        Second = 50,
        Minute = 51,
        Hour = 52,
        Day = 53,
        Calorie = 54,
        Kilocalorie = 55,
        Joule = 56,
        KiloJoule = 57,
        Celsius = 58,
        Fahrenheit = 59,
        Kelvin = 60,
        Count = 61,
        Percent = 62;

    /**
     * @param $unit
     * @return string
     */
    public static function getUnitText($unit){
        switch ($unit){
            case UnitsOfMeasure::Femtoliters:
                return 'fl';
            case UnitsOfMeasure::Grams:
                return 'g';
            case UnitsOfMeasure::GramsPerDeciliter:
                return 'g/dL';
            case UnitsOfMeasure::GramsPerLiter:
                return 'g/L';
            case UnitsOfMeasure::InternationalUnitsPerLiter:
                return 'UI/L';
            case UnitsOfMeasure::InternationalUnitsPerMilliliter:
                return 'UI/mL';
            case UnitsOfMeasure::Micrograms:
                return 'mcg';
            case UnitsOfMeasure::MicrogramsPerDeciliter:
                return 'mcg/dL';
            case UnitsOfMeasure::MicrogramsPerLiter:
                return 'mcg/L';
            case UnitsOfMeasure::MicrokatalsPerLiter:
                return 'mckat/L';
            case UnitsOfMeasure::Microliters:
                return 'mcL';
            case UnitsOfMeasure::MicromolesPerLiter:
                return 'mcmol/L';
            case UnitsOfMeasure::Milliequivalents:
                return 'mEq';
            case UnitsOfMeasure::MilliequivalentsPerLiter:
                return 'mEq/L';
            case UnitsOfMeasure::Milligrams:
                return 'mg';
            case UnitsOfMeasure::MilligramsPerDeciliter:
                return 'mg/dL';
            case UnitsOfMeasure::MilligramsPerLiter:
                return 'mg/L';
            case UnitsOfMeasure::MilliInternationalUnitsPerLiter:
                return 'mIU/L';
            case UnitsOfMeasure::Milliliters:
                return 'mL';
            case UnitsOfMeasure::Millimeters:
                return 'mm';
            case UnitsOfMeasure::MillimetersOfMercury:
                return 'mmHg';
            case UnitsOfMeasure::Millimoles:
                return 'mmol';
            case UnitsOfMeasure::MillimolesPerLiter:
                return 'mmol/L';
            case UnitsOfMeasure::MilliosmolesPerKilogramOfWater:
                return 'mOsm/kg water';
            case UnitsOfMeasure::MilliunitsPerGram:
                return 'mU/g';
            case UnitsOfMeasure::MilliunitsPerLiter:
                return 'mU/L';
            case UnitsOfMeasure::NanogramsPerDeciliter:
                return 'ng/dL';
            case UnitsOfMeasure::NanogramsPerLiter:
                return 'ng/L';
            case UnitsOfMeasure::NanogramsPerMilliliter:
                return 'ng/mL';
            case UnitsOfMeasure::NanogramsPerMilliliterPerHour:
                return 'ng/mL/hr';
            case UnitsOfMeasure::Nanomoles:
                return 'nmol';
            case UnitsOfMeasure::NanomolesPerLiter:
                return 'nmol/L';
            case UnitsOfMeasure::Picograms:
                return 'pg';
            case UnitsOfMeasure::PicogramsPerMilliliter:
                return 'pg/mL';
            case UnitsOfMeasure::PicomolesPerLiter:
                return 'pmol/L';
            case UnitsOfMeasure::Titers:
                return 'titer';
            case UnitsOfMeasure::UnitsPerLiter:
                return 'U/L';
            case UnitsOfMeasure::UnitsPerMilliliter:
                return 'U/mL';
            case UnitsOfMeasure::Kilogram:
                return 'kg';
            case UnitsOfMeasure::Pound:
                return 'lb';
            case UnitsOfMeasure::Meter:
                return 'm';
            case UnitsOfMeasure::Centimeter:
                return 'cm';
            case UnitsOfMeasure::Inch:
                return 'in';
            case UnitsOfMeasure::Foot:
                return 'ft';
            case UnitsOfMeasure::Liter:
                return 'L';
            case UnitsOfMeasure::CentimeterOfWater:
                return 'cmH2O';
            case UnitsOfMeasure::Pascal:
                return 'Pa';
            case UnitsOfMeasure::Atmosphere:
                return 'atm';
            case UnitsOfMeasure::Second:
                return 's';
            case UnitsOfMeasure::Minute:
                return 'min';
            case UnitsOfMeasure::Hour:
                return 'hr';
            case UnitsOfMeasure::Day:
                return 'd';
            case UnitsOfMeasure::Calorie:
                return 'cal';
            case UnitsOfMeasure::Kilocalorie:
                return 'kcal';
            case UnitsOfMeasure::Joule:
                return 'J';
            case UnitsOfMeasure::KiloJoule:
                return 'kJ';
            case UnitsOfMeasure::Celsius:
                return 'C';
            case UnitsOfMeasure::Fahrenheit:
                return 'F';
            case UnitsOfMeasure::Kelvin:
                return 'K';
            case UnitsOfMeasure::Count:
                return 'cnt';
            case UnitsOfMeasure::Percent:
                return '%';
        }
    }

    /**
     * @param $unit
     * @return int
     */
    public static function getUnitEnum($unit){
        switch ($unit){
            case 'fl':
                return UnitsOfMeasure::Femtoliters;
            case 'g':
                return UnitsOfMeasure::Grams;
            case 'g/dL':
                return UnitsOfMeasure::GramsPerDeciliter;
            case 'g/L':
                return UnitsOfMeasure::GramsPerLiter;
            case 'UI/L':
                return UnitsOfMeasure::InternationalUnitsPerLiter;
            case 'UI/mL':
                return UnitsOfMeasure::InternationalUnitsPerMilliliter;
            case 'mcg':
                return UnitsOfMeasure::Micrograms;
            case 'mcg/dL':
                return UnitsOfMeasure::MicrogramsPerDeciliter;
            case 'mcg/L':
                return UnitsOfMeasure::MicrogramsPerLiter;
            case 'mckat/L':
                return UnitsOfMeasure::MicrokatalsPerLiter;
            case 'mcL':
                return UnitsOfMeasure::Microliters;
            case 'mcmol/L':
                return UnitsOfMeasure::MicromolesPerLiter;
            case 'mEq':
                return UnitsOfMeasure::Milliequivalents;
            case 'mEq/L':
                return UnitsOfMeasure::MilliequivalentsPerLiter;
            case 'mg':
                return UnitsOfMeasure::Milligrams;
            case 'mg/dL':
                return UnitsOfMeasure::MilligramsPerDeciliter;
            case 'mg/L':
                return UnitsOfMeasure::MilligramsPerLiter;
            case 'mIU/L':
                return UnitsOfMeasure::MilliInternationalUnitsPerLiter;
            case 'mL':
                return UnitsOfMeasure::Milliliters;
            case 'mm':
                return UnitsOfMeasure::Millimeters;
            case 'mmHg':
                return UnitsOfMeasure::MillimetersOfMercury;
            case 'mmol':
                return UnitsOfMeasure::Millimoles;
            case 'mmol/L':
                return UnitsOfMeasure::MillimolesPerLiter;
            case 'mOsm/kg water':
                return UnitsOfMeasure::MilliosmolesPerKilogramOfWater;
            case 'mU/g':
                return UnitsOfMeasure::MilliunitsPerGram;
            case 'mU/L':
                return UnitsOfMeasure::MilliunitsPerLiter;
            case 'ng/dL':
                return UnitsOfMeasure::NanogramsPerDeciliter;
            case 'ng/L':
                return UnitsOfMeasure::NanogramsPerLiter;
            case 'ng/mL':
                return UnitsOfMeasure::NanogramsPerMilliliter;
            case 'ng/mL/hr':
                return UnitsOfMeasure::NanogramsPerMilliliterPerHour;
            case 'nmol':
                return UnitsOfMeasure::Nanomoles;
            case 'nmol/L':
                return UnitsOfMeasure::NanomolesPerLiter;
            case 'pg':
                return UnitsOfMeasure::Picograms;
            case 'pg/mL':
                return UnitsOfMeasure::PicogramsPerMilliliter;
            case 'pmol/L':
                return UnitsOfMeasure::PicomolesPerLiter;
            case 'titer':
                return UnitsOfMeasure::Titers;
            case 'U/L':
                return UnitsOfMeasure::UnitsPerLiter;
            case 'U/mL':
                return UnitsOfMeasure::UnitsPerMilliliter;
            case 'kg':
                return UnitsOfMeasure::Kilogram;
            case 'lb':
                return UnitsOfMeasure::Pound;
            case 'lbs': // how we currently store it
                return UnitsOfMeasure::Pound;
            case 'm':
                return UnitsOfMeasure::Meter;
            case 'cm':
                return UnitsOfMeasure::Centimeter;
            case 'in':
                return UnitsOfMeasure::Inch;
            case 'inches': // how we currently store it
                return UnitsOfMeasure::Inch;
            case 'ft':
                return UnitsOfMeasure::Foot;
            case 'L':
                return UnitsOfMeasure::Liter;
            case 'cmH2O':
                return UnitsOfMeasure::CentimeterOfWater;
            case 'Pa':
                return UnitsOfMeasure::Pascal;
            case 'atm':
                return UnitsOfMeasure::Atmosphere;
            case 's':
                return UnitsOfMeasure::Second;
            case 'min':
                return UnitsOfMeasure::Minute;
            case 'hr':
                return UnitsOfMeasure::Hour;
            case 'd':
                return UnitsOfMeasure::Day;
            case 'cal':
                return UnitsOfMeasure::Calorie;
            case 'kcal':
                return UnitsOfMeasure::Kilocalorie;
            case 'J':
                return UnitsOfMeasure::Joule;
            case 'kJ':
                return UnitsOfMeasure::KiloJoule;
            case 'C':
                return UnitsOfMeasure::Celsius;
            case 'F':
                return UnitsOfMeasure::Fahrenheit;
            case 'f': // how we currently store it
                return UnitsOfMeasure::Fahrenheit;
            case 'K':
                return UnitsOfMeasure::Kelvin;
            case 'cnt':
                return UnitsOfMeasure::Count;
            case '%':
                return UnitsOfMeasure::Percent;
            default:
                return UnitsOfMeasure::__default;
        }
    }
}