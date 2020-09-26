<?php


namespace PGrafe\PhpCodeGenerator\Service;


use DOMDocument;
use FilesystemIterator;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class XmlFileService
{

    /**
     * @param string $path
     * @return string
     */
    public function buildNicePath(string $path): string
    {
        $nicePathList = [];
        $pathList = explode('/', $path);
        foreach ($pathList as $_path) {
            if ($_path === '..') {
                array_pop($nicePathList);
            } else {
                $nicePathList[] = $_path;
            }
        }

        return implode('/', $nicePathList);
    }

    /**
     * @param string $path
     * @return array
     */
    public function getEnumXmlFileList(string $path): array
    {
        $directory = new RecursiveDirectoryIterator($path, FilesystemIterator::FOLLOW_SYMLINKS);
        $filter = new RecursiveCallbackFilterIterator(
            $directory, function ($current, $key, $iterator) {
            // Skip hidden files and directories.
            if ($current->getFilename()[0] === '.') {
                return false;
            }
            // Recursion
            if ($iterator->hasChildren()) {
                return true;
            }

            // Only consume files of interest.
            return strpos($current->getFilename(), '.pgcg.xml') !== false;
        }
        );
        $iterator = new RecursiveIteratorIterator($filter);
        $fileList = [];
        foreach ($iterator as $info) {
            $fileList[] = $info->getPathname();
        }

        return $fileList;

    }

    /**
     * @param string $path
     * @return DOMDocument[]
     */
    public function getEnumDomDocumentList(string $path): array
    {
        $domDocumentList = [];
        foreach ($this->getEnumXmlFileList($path) as $fileName) {
            $doc = new DOMDocument();
            $doc->load($fileName);
            $domDocumentList[] = $doc;
        }

        return $domDocumentList;
    }

    /**
     * @param string $path
     * @return string
     */
    public function findModuleFolder(string $path): string
    {
        $directory = new RecursiveDirectoryIterator($path, FilesystemIterator::FOLLOW_SYMLINKS);
        $filter = new RecursiveCallbackFilterIterator(
            $directory, function ($current, $key, $iterator) {
            // Recursion
            if ($iterator->hasChildren()) {
                return true;
            }
            // Only path
            if ($current->getFilename() !== '.') {
                return false;
            }
            // skip hidden path
            if ($current->getFilename()[0] === '.' && mb_strlen($current->getFilename()) > 1) {
                return false;
            }

            $pathNameList = explode('/', $current->getPathname());
            $pathNameList = array_reverse($pathNameList);

            // Only consume directories of interest.
            return ($pathNameList[1] === 'module');
        }
        );
        $iterator = new RecursiveIteratorIterator($filter);
        $fileList = [];
        foreach ($iterator as $info) {
            $fileList[] = $info->getPathname();
        }

        if (count($fileList) !== 1) {
            return '';
        }

        return substr($fileList[0], 0, -1);
    }

    /**
     * @param string $path
     * @return DOMDocument[]
     */
    public function getDoctrineDomDocumentList(string $path): array
    {
        $domDocumentList = [];
        foreach ($this->getDoctrineXmlFileList($path) as $fileName) {
            $doc = new DOMDocument();
            $doc->load($fileName);
            $domDocumentList[] = $doc;
        }

        return $domDocumentList;
    }

    /**
     * @param string $path
     * @return string[]
     */
    private function getDoctrineXmlFileList(string $path): array
    {
        $directory = new RecursiveDirectoryIterator($path, FilesystemIterator::FOLLOW_SYMLINKS);
        $filter = new RecursiveCallbackFilterIterator(
            $directory, function ($current, $key, $iterator) {
            // Skip hidden files and directories.
            if ($current->getFilename()[0] === '.') {
                return false;
            }
            // Recursion
            if ($iterator->hasChildren()) {
                return true;
            }

            // Only consume files of interest.
            return strpos($current->getFilename(), '.dcm.xml') !== false;
        }
        );
        $iterator = new RecursiveIteratorIterator($filter);
        $fileList = [];
        foreach ($iterator as $info) {
            $fileList[] = $info->getPathname();
        }

        return $fileList;
    }

}