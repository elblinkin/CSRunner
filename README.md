Create your own Scm.

Create your own Filters.


Then just create a runner with the correct Scm and Filters!

Example

    <?php
    require_once 'CSRunner/Autoload.php';
    
    use CSRunner\Filter\Blacklist;
    use CSRunner\Runner;
    use CSRunner\Scm\Git as Scm;
    
    $phpcs = 'phpcs -p --standard=pear --report=checkstyle --report-file=codesniffer.xml -d memory_limit=-1';
    
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
        $phpcs,
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