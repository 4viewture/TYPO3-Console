<?php
declare(strict_types=1);
(function () {
    $classLoader = require dirname(__DIR__) . '/.Build/vendor/autoload.php';
    $kernel = new \Helhum\Typo3Console\Core\Kernel($classLoader);
    $filter = new \SebastianBergmann\CodeCoverage\Filter();
    $filter->addDirectoryToWhitelist(__DIR__ . '/../Classes');
    $coverage = new \SebastianBergmann\CodeCoverage\CodeCoverage(
        null,
        $filter
    );
    $coverage->start(new class() extends \PHPUnit\Framework\TestCase {
    });
    $output = new \Symfony\Component\Console\Output\BufferedOutput();
    $exitCode = $kernel->handle(new \Helhum\Typo3Console\Mvc\Cli\Symfony\Input\ArgvInput(), $output);
    $coverage->stop();
    echo serialize(
        [
            'exitCode' => $exitCode,
            'coverage' => $coverage,
            'output' => $output->fetch(),
        ]
    );
    $kernel->terminate($exitCode);
})();
