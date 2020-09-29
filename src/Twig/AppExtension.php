<?php


namespace App\Twig;

use App\Entity\Employee;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Repository\ScheduleRepository;

class AppExtension extends AbstractExtension
{
    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getFilters()
    {
        return [
            // the logic of this filter is now implemented in a different class
            new TwigFilter('localTime', [$this, 'getLocalTime'])
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getSchedule', [$this, 'getSchedule']),
            new TwigFunction('getDayName', [$this, 'getDayName']),
        ];
    }

    /**
     * @param $timezone
     * @return string
     */
    public function getLocalTime($timezone)
    {
        date_default_timezone_set($timezone);
        return date('h:i a', time());
    }

    /**
     * @param Employee $teacher
     * @param int $day_id
     * @param string $time
     * @return string
     */
    public function getSchedule($teacher, $day_id, $time)
    {
        return $this->scheduleRepository->getTeacherScheduleByDay($teacher, $day_id, $time);        
    }

    /**
     * @param int $numericDay 
     * @return string
     */
    public function getDayName($numericDay)
    {
        return date('D', strtotime("Sunday +{$numericDay} days"));        
    }
}