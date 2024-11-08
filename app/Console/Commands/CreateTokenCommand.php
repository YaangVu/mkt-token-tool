<?php

namespace App\Console\Commands;

use App\Models\Token;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;

class CreateTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:token
                            {--count=1 : The number of tokens to create}
                            {--team=1 : The team ID to attach the token to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new token';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $count = $this->options['count'] ?? text(
            label: 'Count',
            required: true,
        );

        $teamId = text(
            label: 'Team ID',
            default: 1,
            required: true,
        );

        $ccu = 1000;
        $loop = $count / $ccu;
        for ($i = 0; $i < $loop; $i++) {
            Token::factory($ccu)->create();
            $no = number_format($ccu * ($i + 1)) . '/' . number_format($count);
            $this->info("$no Tokens were created");
        }
    }
}
