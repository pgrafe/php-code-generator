<?php


namespace Application\Enum;


use InvalidArgumentException;


/**
 * State of the application
 */
class ApplicationState
{

    /**
     * @var int
     */
    private int $value;

    /**
     * Waiting
     * @var int
     */
    private const WAITING = 0;

    /**
     * Waiting
     * @return ApplicationState
     */
    public static function WAITING(): ApplicationState
    {
        return new self(self::WAITING);
    }

    /**
     * Success
     * @var int
     */
    private const SUCCESS = 1;

    /**
     * Success
     * @return ApplicationState
     */
    public static function SUCCESS(): ApplicationState
    {
        return new self(self::SUCCESS);
    }

    /**
     * Stopped
     * @var int
     */
    private const STOPPED = 2;

    /**
     * Stopped
     * @return ApplicationState
     */
    public static function STOPPED(): ApplicationState
    {
        return new self(self::STOPPED);
    }

    /**
     * Crashing!
     * @var int
     */
    private const CRASHED = 3;

    /**
     * Crashing!
     * @return ApplicationState
     */
    public static function CRASHED(): ApplicationState
    {
        return new self(self::CRASHED);
    }

    /**
     * @return int[]
     */
    public static function getConstList(): array
    {
        $constList['WAITING'] = self::WAITING;
        $constList['SUCCESS'] = self::SUCCESS;
        $constList['STOPPED'] = self::STOPPED;
        $constList['CRASHED'] = self::CRASHED;
        
        return $constList;
    }

    /**
     * @param int $value
     * @return ApplicationState
     */
    public static function create(int $value): ApplicationState
    {
        foreach (self::getConstList() as $_const => $_value) {
            if ($value === $_value) {
                return self::$_const();
            }
        }
        throw new InvalidArgumentException('invalid enum value: "' . $value . '"');
    }

    /**
     * @param int $value
     * @return bool
     */
    public static function isValidValue(int $value): bool
    {
        return in_array($value, self::getConstList(), true);
    }

    /**
     * ApplicationState constructor
     * @param int $value
     */
    private function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param ApplicationState $applicationState
     * @return bool
     */
    public function equals(ApplicationState $applicationState): bool
    {
        return $applicationState->getValue() === $this->getValue();
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}