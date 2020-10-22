<?php declare(strict_types = 1);

namespace Churn\Process\Handler;

use Churn\Process\Observer\OnSuccess;
use Churn\Process\ProcessFactory;
use Churn\Result\Result;
use Generator;

class SequentialProcessHandler implements ProcessHandler
{
    /**
     * Run the processes sequentially to gather information.
     * @param Generator      $filesFinder    Collection of files.
     * @param ProcessFactory $processFactory Process Factory.
     * @param OnSuccess      $onSuccess      The OnSuccess event observer.
     * @return void
     */
    public function process(
        Generator $filesFinder,
        ProcessFactory $processFactory,
        OnSuccess $onSuccess
    ): void {
        foreach ($filesFinder as $file) {
            $result = new Result($file->getDisplayPath());
            $process = $processFactory->createGitCommitProcess($file);
            $process->start();
            while (!$process->isSuccessful());
            $result->setCommits((int) $process->getOutput());
            $process = $processFactory->createCyclomaticComplexityProcess($file);
            $process->start();
            while (!$process->isSuccessful());
            $result->setComplexity((int) $process->getOutput());
            $onSuccess($result);
        }
    }
}
