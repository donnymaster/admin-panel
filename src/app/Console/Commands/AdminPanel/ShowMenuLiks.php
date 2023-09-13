<?php

namespace App\Console\Commands\AdminPanel;

use Illuminate\Console\Command;
use App\Models\AdminPanel\MenuLink;

class ShowMenuLiks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show list of menu links from admin panel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->table(
            ['Id', 'Name', 'Route', 'Show', 'Parent'],
            MenuLink::with('parent')->get(['id', 'name', 'route', 'is_show'])->toArray()
        );
    }
}
