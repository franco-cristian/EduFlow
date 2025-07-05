<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Project;
use App\Models\Task;
use App\Models\ProjectFile;
use App\Policies\FilePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapear modelos con sus políticas correspondientes.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Task::class => TaskPolicy::class,
        ProjectFile::class => FilePolicy::class,
    ];

    /**
     * Bootstrap de servicios de autorización.
     */
    public function boot(): void
    {
        Gate::define('download-file', [FilePolicy::class, 'download']);
    }
}
