<?php

namespace Webso;

use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class Log
{
    protected $dateFormat = 'd-m-Y H:i:s';

    protected $name = 'webso';

    protected $extension = 'log';

    protected $path;

    /**
     * Tuỳ chỉnh định dạng nội dung Log
     */
    protected function formatter()
    {
        return new LineFormatter(null, $this->dateFormat, true, true, true);
    }

    /**
     * Gán đường dẫn lưu file log
     */
    public function setPath(?string $path = null)
    {
        if (is_string($path)) {
            $this->path = $path;
        }

        return $this;
    }

    /**
     * Khởi tạo
     */
    public static function make(?string $path = null)
    {
        return (new static())->setPath($path)->boot();
    }

    /**
     * Xử lý đường dẫn khi không truyền vào
     */
    protected function handlePath(): void
    {
        if (empty($this->path)) {

            if (function_exists($cnfFind = '\Webso\Helper\cnf_find')) {

                $path = call_user_func($cnfFind, 'path.log');

            } else {
                $path = function_exists('path')
                    ? path()
                    : dirname(__DIR__).DIRECTORY_SEPARATOR.'logs';
            }

        } else {
            $path = $this->path;
        }

        if (! str_ends_with(basename($path), ".{$this->extension}")) {

            $path = str($path)
                ->append(DIRECTORY_SEPARATOR, $this->name, '.', $this->extension)
                ->toString();
        }

        $this->path = $path;
    }

    /**
     * Lấy đường dẫn lưu log
     */
    protected function getPath()
    {
        $this->handlePath();

        return $this->path;
    }

    /**
     * Gọi thư viện
     */
    protected function boot(): \Illuminate\Log\Logger
    {
        $monolog = new \Monolog\Logger($this->name);

        $monolog->pushHandler(
            (new StreamHandler($this->getPath(), \Monolog\Level::Debug))
                ->setFormatter($this->formatter())
        );

        // Tạo một instance của Illuminate Logger
        return new \Illuminate\Log\Logger($monolog);
    }

    /**
     * Ghi nhật ký
     */
    protected static function writeLog(string $level, $message, array $context = [])
    {
        $levels = self::levels();

        if (in_array($level, $levels)) {
            (new self())->boot()->{$level}($message, $context);
        }
    }

    public static function levels(): array
    {
        return [
            'debug',
            'info',
            'notice',
            'warning',
            'error',
            'critical',
            'alert',
            'emergency',
        ];
    }

    public static function debug($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }

    public static function info($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }

    public static function notice($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }

    public static function warning($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }

    public static function error($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }

    public static function critical($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }

    public static function alert($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }

    public static function emergency($message, array $context = [])
    {
        static::writeLog(__FUNCTION__, $message, $context);
    }
}
