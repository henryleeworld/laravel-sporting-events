<?php

namespace App\View\Composers;

use App\Models\Charity;
use App\Models\Region;
use App\Models\Sport;
use Illuminate\View\View;

class SearchComposer
{
    public function compose(View $view)
    {
        $view->with([
            'searchSports' => Sport::pluck('name', 'id'),
            'searchRegions' => Region::pluck('name', 'id'),
            'searchCharities' => Charity::pluck('name', 'id'),
        ]);
    }
}
