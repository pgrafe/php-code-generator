<?php


namespace PGrafe\PhpCodeGenerator\Enum;


use InvalidArgumentException;


/**
 * Php types
 */
class PhpType
{

    /**
     * @var string
     */
    private string $value;

    /**
     * Ein Kommentar
     * @var string
     */
    private const ARRAY = 'array';

    /**
     * Ein Kommentar
     * @return PhpType
     */
    public static function ARRAY(): PhpType
    {
        return new self(self::ARRAY);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const INT = 'int';

    /**
     * Ein Kommentar
     * @return PhpType
     */
    public static function INT(): PhpType
    {
        return new self(self::INT);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const FLOAT = 'float';

    /**
     * Ein Kommentar
     * @return PhpType
     */
    public static function FLOAT(): PhpType
    {
        return new self(self::FLOAT);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATETIME = 'DateTime';

    /**
     * Ein Kommentar
     * @return PhpType
     */
    public static function DATETIME(): PhpType
    {
        return new self(self::DATETIME);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const BOOL = 'bool';

    /**
     * Ein Kommentar
     * @return PhpType
     */
    public static function BOOL(): PhpType
    {
        return new self(self::BOOL);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const STRING = 'string';

    /**
     * Ein Kommentar
     * @return PhpType
     */
    public static function STRING(): PhpType
    {
        return new self(self::STRING);
    }

    /**
     * @return string[]
     */
    public static function getConstList(): array
    {
        $constList['ARRAY'] = self::ARRAY;
        $constList['INT'] = self::INT;
        $constList['FLOAT'] = self::FLOAT;
        $constList['DATETIME'] = self::DATETIME;
        $constList['BOOL'] = self::BOOL;
        $constList['STRING'] = self::STRING;
        
        return $constList;
    }

    /**
     * @param string $value
     * @return PhpType
     */
    public static function create(string $value): PhpType
    {
        foreach (self::getConstList() as $_const => $_value) {
            if ($value === $_value) {
                return self::$_const();
            }
        }
        throw new InvalidArgumentException('invalid enum value: "' . $value . '"');
    }

    /**
     * @param string $value
     * @return bool
     */
    public static function isValidValue(string $value): bool
    {
        return in_array($value, self::getConstList(), true);
    }

    /**
     * PhpType constructor
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param PhpType $phpType
     * @return bool
     */
    public function equals(PhpType $phpType): bool
    {
        return $phpType->getValue() === $this->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}