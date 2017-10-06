<?php declare(strict_types = 1);

namespace Churn\Factories;

use Churn\Configuration\Config;
use Churn\Processes\ChurnProcess;
use Churn\Values\File;
use Symfony\Component\Process\Process;

class ProcessFactory
{
    /**
     * The config values.
     * @var Config
     */
    private $config;

    /**
     * ProcessFactory constructor.
     * @param Config $config Configuration Settings.
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Creates a Git Commit Process that will run on $file.
     * @param File $file File that the process will execute on.
     * @return ChurnProcess
     */
    public function createGitCommitProcess(File $file): ChurnProcess
    {
        $process = new Process(
            'git -C ' . getcwd() . " log --since=\"" . $this->config->getCommitsSince() . "\"  --name-only --pretty=format: " . $file->getFullPath(). " | sort | uniq -c | sort -nr"
        );

        return new ChurnProcess($file, $process, 'GitCommitProcess');
    }

    /**
     * Creates a Cyclomatic Complexity Process that will run on $file.
     * @param File $file File that the process will execute on.
     * @return ChurnProcess
     */
    public function createCyclomaticComplexityProcess(File $file): ChurnProcess
    {
        $script = $_SERVER['argv'][0];

        $process = new Process(
            "php {$script} assess-complexity {$file->getFullPath()}"
        );

        return new ChurnProcess($file, $process, 'CyclomaticComplexityProcess');
    }
}
