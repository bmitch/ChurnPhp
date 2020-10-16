<?php declare(strict_types = 1);

namespace Churn\Renderers\Results;

use Churn\Results\ResultCollection;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleResultsRenderer implements ResultsRendererInterface
{
    /**
     * Renders the results.
     * @param OutputInterface  $output  Output Interface.
     * @param ResultCollection $results Result Collection.
     * @return void
     */
    public function render(OutputInterface $output, ResultCollection $results): void
    {
        $output->writeln("\n");

        $table = new Table($output);
        $table->setHeaders(['File', 'Times Changed', 'Complexity', 'Score']);
        $table->addRows($results->toArray());
        $table->render();

        $output->write("\n");
    }
}
