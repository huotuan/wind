<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Layout\Row;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use App\Admin\Metrics\Examples;
use App\Admin\Metrics\Dashboard;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
        ->header(get_agent('name')??'小助手')
        ->description('同步于：'.get_agent('updated_at'))
            ->body(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->row(Dashboard::title());
                });
            });
    }
}
