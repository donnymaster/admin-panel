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
        $itemMenu = MenuLink::where('id', $id)->first();

        if (!$itemMenu) {
            $this->error('Menu item not found!');
            return;
        }

        if ($type === self::HIDE) {
            $itemMenu->update(['is_show' => 0]);
            MenuLink::where('parent', $id)->update(['is_show' => 0]);
            $this->info("The menu item [{$itemMenu->name}] was successfully hidden!");
        }

        if ($type === self::SHOW) {
            $itemMenu->update(['is_show' => 1]);
            MenuLink::where('parent', $id)->update(['is_show' => 1]);
            $this->info("The menu item [{$itemMenu->name}] was successfully displayed!");
        }
    }
}
