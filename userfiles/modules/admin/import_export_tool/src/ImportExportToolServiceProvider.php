<?php
/*
 * This file is part of the Microweber framework.
 *
 * (c) Microweber CMS LTD
 *
 * For full license information see
 * https://github.com/microweber/microweber/blob/master/LICENSE
 *
 */

namespace MicroweberPackages\Modules\Admin\ImportExportTool;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use MicroweberPackages\Modules\Admin\ImportExportTool\Http\Livewire\Counter;
use MicroweberPackages\Modules\Admin\ImportExportTool\Http\Livewire\HtmlDropdownMappingPreview;
use MicroweberPackages\Modules\Admin\ImportExportTool\Http\Livewire\NewImportModal;
use MicroweberPackages\Modules\Admin\ImportExportTool\Http\Livewire\NoFeeds;
use MicroweberPackages\Modules\Admin\ImportExportTool\Http\Livewire\ViewImport;

class ImportExportToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Livewire::component('import_export_tool_no_feeds', NoFeeds::class);
        Livewire::component('import_export_tool_new_import_modal', NewImportModal::class);
        Livewire::component('import_export_tool_view_import', ViewImport::class);
        Livewire::component('import_export_tool_html_dropdown_mapping_preview', HtmlDropdownMappingPreview::class);

        View::addNamespace('import_export_tool', normalize_path((__DIR__) . '/resources/views'));


    }

    public function register()
    {
        $this->loadMigrationsFrom(normalize_path((__DIR__) . '/migrations/'));
        $this->loadRoutesFrom((__DIR__) . '/routes/admin.php');
    }
}
