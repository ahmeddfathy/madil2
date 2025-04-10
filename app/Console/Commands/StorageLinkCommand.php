<?php

namespace Illuminate\Foundation\Console\Commands;

use Illuminate\Console\Command;

class StorageLinkCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'storage:link {--relative : Create the symbolic link using relative paths}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the symbolic links configured for the application';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $links = $this->laravel['config']['filesystems.links'] ??
               [public_path('storage') => storage_path('app/public')];

        foreach ($links as $link => $target) {
            if (file_exists($link)) {
                $this->error("The [$link] link already exists.");
                continue;
            }

            if ($this->option('relative')) {
                $this->laravel->make('files')->relativeLink($target, $link);
            } else {
                $this->laravel->make('files')->link($target, $link);
            }

            $this->info("The [$link] link has been connected to [$target].");
        }

        $this->info('The links have been created.');
    }
}
