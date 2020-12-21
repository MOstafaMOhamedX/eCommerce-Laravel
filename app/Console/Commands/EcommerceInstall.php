<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EcommerceInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eCommerce:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install dummy data for the eCommerce App';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        File::deleteDirectory(public_path('storage/products'));
        File::deleteDirectory(public_path('storage/settings'));
        File::deleteDirectory(public_path('storage/pages'));
        File::deleteDirectory(public_path('storage/posts'));
        File::deleteDirectory(public_path('storage/users'));

        $this->callSilent('storage:link');
        $copySuccess = File::copyDirectory(public_path('img/products'), public_path('storage/products/dummy'));
        if ($copySuccess) {
            $this->info('Images successfully copied to storage folder.');
        }

        File::copyDirectory(public_path('img/pages'), public_path('storage/pages'));
        File::copyDirectory(public_path('img/posts'), public_path('storage/posts'));
        File::copyDirectory(public_path('img/users'), public_path('storage/users'));

        try {
            $this->call('migrate:fresh', [
                '--seed' => true,
                '--force' => true,
            ]);
        } catch (\Exception $e) {
            $this->error('Algolia credentials incorrect. Your products table is NOT seeded correctly. If you are not using Algolia, remove Laravel\Scout\Searchable from App\Models\Product');
        }

        // $this->call('db:seed', [
        //     '--class' => 'VoyagerDatabaseSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'VoyagerDummyDatabaseSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'DataTypesTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'DataRowsTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'MenusTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'MenuItemsTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'RolesTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'PermissionsTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'PermissionRoleTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'UsersTableSeeder',
        //     '--force' => true,
        // ]);

        // $this->call('db:seed', [
        //     '--class' => 'SettingsTableSeeder',
        //     '--force' => true,
        // ]);

        try {
            $this->call('scout:clear', [
                'model' => 'App\\Models\\Product',
            ]);

            $this->call('scout:import', [
                'model' => 'App\\Models\\Product',
            ]);
        } catch (\Exception $e) {
            $this->error('Algolia credentials incorrect. Check your .env file. Make sure ALGOLIA_APP_ID and ALGOLIA_SECRET are correct.');
        }

        $this->info('Dummy data installed');
    }
}
