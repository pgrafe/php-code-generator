<?php


namespace PGrafe\PhpCodeGenerator\Model;


class DoctrineBuildModel
{

    /**
     * @var string
     */
    private string $base_path = '';

    /**
     * @var string
     */
    private string $name = '';

    /**
     * @var string
     */
    private string $path = '';

    /**
     * @var string
     */
    private string $nameSpace = '';

    /**
     * @var array
     */
    private array $field_list = [];
    /**
     * @var string[]
     */
    private array $message_list;
    /**
     * @var bool
     */
    private bool $status = false;
    /**
     * @var string
     */
    private string $extends = '';

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->base_path;
    }

    /**
     * @param string $base_path
     */
    public function setBasePath(string $base_path): void
    {
        $this->base_path = $base_path;
    }

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
     * @return array
     */
    public function getFieldList(): array
    {
        return $this->field_list;
    }

    /**
     * @param array $field_list
     */
    public function setFieldList(array $field_list): void
    {
        $this->field_list = $field_list;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->nameSpace;
    }

    /**
     * @param string $nameSpace
     */
    public function setNameSpace(string $nameSpace): void
    {
        $this->nameSpace = $nameSpace;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->getBasePath() . $this->getPath() . $this->getName() . '.php';
    }

    /**
     * @param string $string
     */
    public function addMessage(string $string): void
    {
        $this->message_list[] = $string;
    }

    /**
     * @return string[]
     */
    public function getMessageList(): array
    {
        return $this->message_list;
    }

    /**
     * @param string[] $message_list
     */
    public function setMessageList(array $message_list): void
    {
        $this->message_list = [];
        foreach ($message_list as $_message) {
            $this->addMessage($_message);
        }
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @param string $className
     */
    public function addExtends(string $className):void
    {
        $this->extends = $className;
    }

    /**
     * @return string
     */
    public function getExtends(): string
    {
        return $this->extends;
    }

}