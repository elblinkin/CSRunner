Create your own Scm.

Create your own Filters.


Then just create a runner with the correct Scm and Filters!

Example

    <?php
    require_once 'CSRunner/Autoload.php';
    
    
    use CSRunner\CodeSnifferCommand\Command as CodeSnifferCommand;
    use CSRunner\Filter\Blacklist;
    use CSRunner\Finder\PassThrough as PassThroughFinder
    use CSRunner\LintCommand\Command as LintCommand;
    use CSRunner\LintCommand\Linter;
    use CSRunner\LintCommand\Reporter as LintReporter;
    use CSRunner\Runner;
    use CSRunner\Scm\Git as Scm;
    
    $finder = new PassThroughFinder();
    
    $phpcs = 'phpcs -p --standard=pear --report=checkstyle --report-file=codesniffer.xml -d memory_limit=-1
    
    $phpcs_command = new CodeSnifferCommand($phpcs, $finder);
    
    $writer = new XmlWriter;
    $writer->openURI('lint.xml');
    $reporter = new LintReporter($writer);
    $lint_command = new LintCommand(
        $finder,
        'php -l -c /etc/php.ini',
        $reporter
    );
    
    $scm = new Scm(
        'origin',
        'master',
        5
    );
    
    $filters = array(
        new Blacklist(
            array(
                '*phplib/Thrift/Thrift.php',
                '*phplib/Thrift/autoload.php',
                '*phplib/Thrift/client/*',
                '*phplib/Thrift/packages/*',
                '*phplib/Thirft/protocol/*',
                '*phplib/Thrift/transport/*',
                '*phplib/twilio.php',
            )
        ),
    );
    
    $runner = new Runner(
        array(
            $lint_command,
            $phpcs
        ),
        $scm,
        $filters
    );
    $runner->run(
        array(
            'phplib',
            'tests/phpunit',
        )
    );
    ?>