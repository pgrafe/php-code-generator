<?php


namespace PGrafe\PhpCodeGenerator\Model;


class EnumConstModel
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $value;

    /**
     * @var string
     */
    private string $nice_value;

    /**
     * @var string
     */
    private string $comment;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getNiceValue(): string
    {
        return $this->nice_value;
    }

    /**
     * @param string $nice_value
     */
    public function setNiceValue(string $nice_value): void
    {
        $this->nice_value = $nice_value;
    }

}