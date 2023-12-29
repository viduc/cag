<?php
use Kahlan\Util\Text;
use Kahlan\Suite;

// It overrides some default option values.
// Note that the values passed in command line will overwrite the ones below.
$commandLine = $this->commandLine();
$commandLine->option('ff', 'default', 1);
$commandLine->option('coverage', 'default', 4);
$commandLine->option('reporter', 'default', 'verbose');
$commandLine->option('clover', 'default', 'clover-kahlan.xml');

function with_provided_data_it(
    string         $message,
    callable       $closure,
    array|callable $provider = [],
    int|null       $timeout = null,
    string         $scope = 'normal'
): void {
    $data = is_callable($provider) ? $provider() : $provider;
    foreach ($data as $values) {
        Suite::current()->it(
            message: Text::insert($message, $values),
            closure: function() use ($closure, $values) {
                call_user_func_array($closure, $values);
            },
            timeout: $timeout,
            type: $scope
        );
    }
}
