<?php

namespace App\Console\Commands\AdminPanel;

use App\Models\AdminPanel\MenuLink;
use Illuminate\Console\Command;

class UpdateMenuLiks extends Command
{
    const HIDE = 'hide';
    const SHOW = 'show';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:update {id} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $type = $this->argument('type');

        if ($type === self::HIDE) {
            MenuLink::where('id', $id)->update(['is_show' => 0]);
        }

        if ($type === self::SHOW) {
            MenuLink::where('id', $id)->update(['is_show' => 1]);
        }
    }
}
