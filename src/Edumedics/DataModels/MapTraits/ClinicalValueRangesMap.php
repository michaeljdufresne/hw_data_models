<?php


namespace Edumedics\DataModels\MapTraits;


trait ClinicalValueRangesMap
{

    /**
     * @var array
     */
    protected $comparators = [ '<', '<=', '=', '>', '>=' ];

    /**
     * @var array
     */
    protected $a1cRanges = [
        1 => [ '<', 7 ],
        2 => [ 7, 7.9 ],
        3 => [ 8, 8.9 ],
        4 => [ '>=', 9 ]
    ];

    /**
     * @var array
     */
    protected $sbpRanges = [
        1 => [ '<', 120 ],
        2 => [ 120, 139 ],
        3 => [ '>=', 140 ]
    ];

    /**
     * @var array
     */
    protected $dbpRanges = [
        1 => ['<', 80 ],
        2 => [ 80, 89 ],
        3 => [ '>=', 90 ]
    ];

    /**
     * @var array
     */
    protected $ldlRanges = [
        1 => [ '<', 100 ],
        2 => [ 100, 159 ],
        3 => [ 160, 189 ],
        4 => [ '>=', 190 ]
    ];

    /**
     * @var array
     */
    protected $tcHdlRanges = [
        1 => [ '<', 3.5 ],
        2 => [ 3.5, 4.4 ],
        3 => [ 4.5, 4.9 ],
        4 => [ '>=', 5 ]
    ];

    protected $triglyceridesRanges = [
        1 => [ '<', 150 ],
        2 => [ 150, 499 ],
        3 => [ '>=', 500 ],
    ];

    /**
     * @var array
     */
    protected $bmiRanges = [
        1 => [ '<', 18.5 ],
        2 => [ 18.5, 24.9 ],
        3 => [ 25, 29.9 ],
        4 => [ 30.0, 34.9 ],
        5 => [ 35, 39.9 ],
        6 => [ '>=', 40 ],
    ];

    /**
     * @param $ranges
     * @param $value
     * @return int|null|string
     */
    protected function evaluateRanges($ranges, $value)
    {
        $value = round($value, 1);
        foreach ($ranges as $score => $range)
        {
            if (in_array($range[0], $this->comparators))
            {
                if (version_compare($value, $range[1], $range[0]))
                {
                    return $score;
                }
            }
            else
            {
                if (($value >= $range[0]) && ($value <= $range[1]))
                {
                    return $score;
                }
            }
        }
        return null;
    }

}