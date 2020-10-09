<?php declare(strict_types = 1);


namespace Churn\Processes;

use Churn\Values\File;
use Symfony\Component\Process\Process;

class ChurnProcess
{
    /**
     * The file the process will be executed on.
     * @var File
     */
    private $file;

    /**
     * The type of process.
     * @var string
     */
    private $type;

    /**
     * The Symfony Process Component.
     * @var Process
     */
    private $process;

    /**
     * GitCommitCountProcess constructor.
     * @param File    $file    The file the process is being executed on.
     * @param Process $process The process being executed on the file.
     * @param string  $type    The type of process.
     */
    public function __construct(File $file, Process $process, string $type)
    {
        $this->file = $file;
        $this->process = $process;
        $this->type = $type;
    }

    /**
     * Start the process.
     * @return void
     */
    public function start(): void
    {
        $this->process->start();
    }

    /**
     * Determines if the process was successful.
     * @return boolean
     * @throws ProcessFailedException If the process failed.
     */
    public function isSuccessful(): bool
    {
        return $this->process->isSuccessful();
    }

    /**
     * Gets the output of the process.
     * @return string
     */
    public function getOutput(): string
    {
        return $this->process->getOutput();
    }

    /**
     * Gets the file name of the file the process
     * is being executed on.
     * @return string
     */
    public function getFilename(): string
    {
        return $this->file->getDisplayPath();
    }

    /**
     * Gets a unique key used for storing the process in data structures.
     * @return string
     */
    public function getKey(): string
    {
        return $this->getType() . $this->file->getFullPath();
    }

    /**
     * Get the type of this process.
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
