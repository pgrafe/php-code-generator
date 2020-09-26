<?php


namespace PGrafe\PhpCodeGenerator\Enum;


use InvalidArgumentException;


/**
 * Hallo ein Kommentar
 * Noch ein Kommentar
 */
class DoctrineType
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
     * @return DoctrineType
     */
    public static function ARRAY(): DoctrineType
    {
        return new self(self::ARRAY);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const BIGINT = 'bigint';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function BIGINT(): DoctrineType
    {
        return new self(self::BIGINT);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const BINARY = 'binary';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function BINARY(): DoctrineType
    {
        return new self(self::BINARY);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const BLOB = 'blob';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function BLOB(): DoctrineType
    {
        return new self(self::BLOB);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const BOOLEAN = 'boolean';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function BOOLEAN(): DoctrineType
    {
        return new self(self::BOOLEAN);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATE_MUTABLE = 'date';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DATE_MUTABLE(): DoctrineType
    {
        return new self(self::DATE_MUTABLE);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATE_IMMUTABLE = 'date_immutable';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DATE_IMMUTABLE(): DoctrineType
    {
        return new self(self::DATE_IMMUTABLE);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATEINTERVAL = 'dateinterval';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DATEINTERVAL(): DoctrineType
    {
        return new self(self::DATEINTERVAL);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATETIME_MUTABLE = 'datetime';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DATETIME_MUTABLE(): DoctrineType
    {
        return new self(self::DATETIME_MUTABLE);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATETIME_IMMUTABLE = 'datetime_immutable';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DATETIME_IMMUTABLE(): DoctrineType
    {
        return new self(self::DATETIME_IMMUTABLE);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATETIMETZ_MUTABLE = 'datetimetz';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DATETIMETZ_MUTABLE(): DoctrineType
    {
        return new self(self::DATETIMETZ_MUTABLE);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DATETIMETZ_IMMUTABLE = 'datetimetz_immutable';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DATETIMETZ_IMMUTABLE(): DoctrineType
    {
        return new self(self::DATETIMETZ_IMMUTABLE);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const DECIMAL = 'decimal';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function DECIMAL(): DoctrineType
    {
        return new self(self::DECIMAL);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const FLOAT = 'float';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function FLOAT(): DoctrineType
    {
        return new self(self::FLOAT);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const GUID = 'guid';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function GUID(): DoctrineType
    {
        return new self(self::GUID);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const INTEGER = 'integer';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function INTEGER(): DoctrineType
    {
        return new self(self::INTEGER);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const JSON = 'json';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function JSON(): DoctrineType
    {
        return new self(self::JSON);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const OBJECT = 'object';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function OBJECT(): DoctrineType
    {
        return new self(self::OBJECT);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const SIMPLE_ARRAY = 'simple_array';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function SIMPLE_ARRAY(): DoctrineType
    {
        return new self(self::SIMPLE_ARRAY);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const SMALLINT = 'smallint';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function SMALLINT(): DoctrineType
    {
        return new self(self::SMALLINT);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const STRING = 'string';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function STRING(): DoctrineType
    {
        return new self(self::STRING);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const TEXT = 'text';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function TEXT(): DoctrineType
    {
        return new self(self::TEXT);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const TIME_MUTABLE = 'time';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function TIME_MUTABLE(): DoctrineType
    {
        return new self(self::TIME_MUTABLE);
    }

    /**
     * Ein Kommentar
     * @var string
     */
    private const TIME_IMMUTABLE = 'time_immutable';

    /**
     * Ein Kommentar
     * @return DoctrineType
     */
    public static function TIME_IMMUTABLE(): DoctrineType
    {
        return new self(self::TIME_IMMUTABLE);
    }

    /**
     * @return string[]
     */
    public static function getConstList(): array
    {
        $constList['ARRAY'] = self::ARRAY;
        $constList['BIGINT'] = self::BIGINT;
        $constList['BINARY'] = self::BINARY;
        $constList['BLOB'] = self::BLOB;
        $constList['BOOLEAN'] = self::BOOLEAN;
        $constList['DATE_MUTABLE'] = self::DATE_MUTABLE;
        $constList['DATE_IMMUTABLE'] = self::DATE_IMMUTABLE;
        $constList['DATEINTERVAL'] = self::DATEINTERVAL;
        $constList['DATETIME_MUTABLE'] = self::DATETIME_MUTABLE;
        $constList['DATETIME_IMMUTABLE'] = self::DATETIME_IMMUTABLE;
        $constList['DATETIMETZ_MUTABLE'] = self::DATETIMETZ_MUTABLE;
        $constList['DATETIMETZ_IMMUTABLE'] = self::DATETIMETZ_IMMUTABLE;
        $constList['DECIMAL'] = self::DECIMAL;
        $constList['FLOAT'] = self::FLOAT;
        $constList['GUID'] = self::GUID;
        $constList['INTEGER'] = self::INTEGER;
        $constList['JSON'] = self::JSON;
        $constList['OBJECT'] = self::OBJECT;
        $constList['SIMPLE_ARRAY'] = self::SIMPLE_ARRAY;
        $constList['SMALLINT'] = self::SMALLINT;
        $constList['STRING'] = self::STRING;
        $constList['TEXT'] = self::TEXT;
        $constList['TIME_MUTABLE'] = self::TIME_MUTABLE;
        $constList['TIME_IMMUTABLE'] = self::TIME_IMMUTABLE;

        return $constList;
    }

    /**
     * @param string $value
     * @return DoctrineType
     */
    public static function create(string $value): DoctrineType
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
     * DoctrineType constructor
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param DoctrineType $doctrineType
     * @return bool
     */
    public function equals(DoctrineType $doctrineType): bool
    {
        return $doctrineType->getValue() === $this->getValue();
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}