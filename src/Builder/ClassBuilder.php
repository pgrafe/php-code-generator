<?php


namespace PGrafe\PhpPGrafe\PhpCodeGenerator\Builder;


class ClassBuilder
{

    /**
     * @var array
     */
    private array $contentList = [];
    /**
     * @var string
     */
    private string $class_name;
    /**
     * @var string
     */
    private string $name_space;
    /**
     * @var array
     */
    private array $use_class_list = [];
    /**
     * @var string
     */
    private string $extends = '';
    /**
     * @var string[]
     */
    private array $comment_list = [];

    /**
     * @param string $contentLine
     */
    public function addContentLine(string $contentLine): void
    {
        $this->contentList[] = $contentLine;
    }

    /**
     * @return array
     */
    public function getContentList(): array
    {
        return $this->contentList;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->class_name = $className;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->class_name;
    }

    /**
     * @param string $nameSpace
     */
    public function setNameSpace(string $nameSpace): void
    {
        $this->name_space = $nameSpace;
    }

    /**
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->name_space;
    }

    /**
     * @param string $className
     */
    public function addUseClass(string $className): void
    {
        $this->use_class_list[$className] = $className;
        ksort($this->use_class_list);
    }

    /**
     * @return array
     */
    public function getUseClassList(): array
    {
        return $this->use_class_list;
    }

    /**
     * @return string
     */
    public function buildClass(): string
    {
        $contentList   = [];
        $contentList[] = '<?php';
        $contentList[] = '';
        $contentList[] = '';
        $contentList[] = 'namespace ' . $this->getNameSpace() . ';';
        $contentList[] = '';
        $contentList[] = '';
        foreach ($this->getUseClassList() as $_useClass) {
            $contentList[] = 'use ' . $_useClass . ';';
        }
        $contentList[] = '';
        $contentList[] = '';

        if (count($this->getCommentList()) > 0) {
            $contentList[] = '/**';
            foreach ($this->getCommentList() as $_comment) {
                $contentList[] = ' * ' . trim($_comment);
            }
            $contentList[] = ' */';
        }

        $extends = '';
        if ($this->getExtendsName() !== '') {
            $extends = ' extends ' . $this->getExtendsName();
        }
        $contentList[] = 'class ' . $this->getClassName() . $extends;
        $contentList[] = '{';

        $tabCount = 1;
        foreach ($this->getContentList() as $_content) {
            $_contentLine = trim($_content);

            if ($_contentLine === '/**') {
                $contentList[] = '';
            }
            if (mb_strpos($_contentLine, '*') === 0) {
                $_contentLine = ' ' . $_contentLine;
            }
            if (mb_strpos($_contentLine, '}') !== false) {
                $tabCount--;
            }
            for ($_tabCount = 0; $_tabCount < $tabCount; $_tabCount++) {
                $_contentLine = '    ' . $_contentLine;
            }
            $contentList[] = $_contentLine;
            if (mb_strpos($_contentLine, '{') !== false) {
                $tabCount++;
            }
        }
        $contentList[] = '}';

        return implode("\n", $contentList);
    }

    /**
     * @param array $commentList
     */
    public function addCommentBlock(array $commentList): void
    {
        if (count($commentList) === 0) {
            return;
        }
        $this->addContentLine('/**');
        foreach ($commentList as $_commentLine) {
            $this->addContentLine('* ' . trim($_commentLine));
        }
        $this->addContentLine('*/');
    }

    /**
     * @param string $className
     */
    public function setExtends(string $className): void
    {
        $this->extends = $className;
        if ($this->extends !== '') {
            $this->addUseClass($this->extends);
        }
    }

    /**
     * @return string
     */
    private function getExtendsName(): string
    {
        $fullyQualifiedClassNameList = explode('\\', $this->extends);

        return array_pop($fullyQualifiedClassNameList);
    }

    /**
     * @param array $commentList
     */
    public function setCommentList(array $commentList): void
    {
        $this->comment_list = [];
        foreach ($commentList as $_comment) {
            $this->addComment($_comment);
        }
    }

    /**
     * @param string $_comment
     */
    private function addComment(string $_comment): void
    {
        $this->comment_list[] = $_comment;
    }

    /**
     * @return string[]
     */
    public function getCommentList(): array
    {
        return $this->comment_list;
    }

}