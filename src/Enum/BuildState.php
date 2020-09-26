<?php


namespace PGrafe\PhpCodeGenerator\Enum;


use InvalidArgumentException;


/**
 * State of the build process
 */
class BuildState
{

    /**
     * @var int
     */
    private int $value;

    /**
     * Ready to be build
     * @var int
     */
    private const READY = 0;

    /**
     * Ready to be build
     * @return BuildState
     */
    public static function READY(): BuildState
    {
        return new self(self::READY);
    }

    /**
     * Successfully build
     * @var int
     */
    private const SUCCESS = 1;

    /**
     * Successfully build
     * @return BuildState
     */
    public static function SUCCESS(): BuildState
    {
        return new self(self::SUCCESS);
    }

    /**
     * No XML data found to be processed
     * @var int
     */
    private const NO_XML_FOUND = 2;

    /**
     * No XML data found to be processed
     * @return BuildState
     */
    public static function NO_XML_FOUND(): BuildState
    {
        return new self(self::NO_XML_FOUND);
    }

    /**
     * General build failure
     * @var int
     */
    private const BUILD_FAILED = 3;

    /**
     * General build failure
     * @return BuildState
     */
    public static function BUILD_FAILED(): BuildState
    {
        return new self(self::BUILD_FAILED);
    }

    /**
     * @return int[]
     */
    public static function getConstList(): array
    {
        $constList['READY'] = self::READY;
        $constList['SUCCESS'] = self::SUCCESS;
        $constList['NO_XML_FOUND'] = self::NO_XML_FOUND;
        $constList['BUILD_FAILED'] = self::BUILD_FAILED;
        
        return $constList;
    }

    /**
     * @param int $value
     * @return BuildState
     */
    public static function create(int $value): BuildState
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
     * BuildState constructor
     * @param int $value
     */
    private function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param BuildState $buildState
     * @return bool
     */
    public function equals(BuildState $buildState): bool
    {
        return $buildState->getValue() === $this->getValue();
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}