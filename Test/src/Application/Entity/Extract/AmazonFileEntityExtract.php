<?php


namespace Application\Entity\Extract;


use DateTime;


class AmazonFileEntityExtract
{

    /**
     * @var int
     */
    protected int $id;

    /**
     * @var string
     */
    protected string $dirname;

    /**
     * @var string
     */
    protected string $basename;

    /**
     * @var string
     */
    protected string $extension;

    /**
     * @var int
     */
    protected int $status;

    /**
     * @var string
     */
    protected string $file_name;

    /**
     * @var string
     */
    protected string $file_name_md5;

    /**
     * @var DateTime
     */
    protected DateTime $file_date_time;

    /**
     * @var int
     */
    protected int $file_size;

    /**
     * @var string
     */
    protected string $file_md5;

    /**
     * @var array
     */
    protected array $exif_data;
}