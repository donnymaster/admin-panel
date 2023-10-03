<?php

namespace App\Traits\Blade;

use App\Models\AdminPanel\MenuLink;
use Illuminate\Support\Facades\Blade;

trait DirectiveVisibleByPageTrait
{
    public function directiveCheckVisibleByPageName()
    {
        Blade::directive('checkVisible', function ($route) {
            $link = MenuLink::where('route', 'like', "%$route%")->first();

            if (!$link) {
                return '<?php if(true): ?>';
            }

            return "<?php if({$link->is_show}): ?>";
        });

        Blade::directive('endCheckVisible', function () {
            return "<?php endif; ?>";
        });
    }
}
