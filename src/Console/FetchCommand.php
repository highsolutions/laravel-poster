<?php 

namespace HighSolutions\Poster\Console;

use HighSolutions\Poster\Services\Poster;
use Illuminate\Console\Command;

class FetchCommand extends Command 
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'poster:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all posts from all social pages.';

    /** @var \HighSolutions\Poster\Services\Poster  */
    protected $poster;

    public function __construct(Poster $poster)
    {
        parent::__construct();
        $this->poster = $poster;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->poster->fetchAll();
        $this->info("All pages are fetched!");
    }

}
