<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Operation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get operation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info("Select the command
- Select
- Update
- Delete
- Add");

        $operation = $this->choice(
            'Which operation would you like to perform?', 
            ['Select', 'Update', 'Delete', 'Add'], 
            0
        );

        $this->info("you selected {$operation}");
    }
}
