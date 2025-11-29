<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Ticket;

class SetupApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the application: create databases and run migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting application setup...');

        // 1. Check .env
        if (!file_exists(base_path('.env'))) {
            $this->info('Creating .env file...');
            copy(base_path('.env.example'), base_path('.env'));
            $this->call('key:generate');
        }

        // 2. Create Databases
        if ($this->createDatabases() === false) {
            return;
        }

        // 3. Run Migrations
        $this->runMigrations();

        $this->info('Application setup completed successfully!');
    }

    protected function createDatabases()
    {
        $this->info('Checking databases...');

        $host = config('database.connections.mysql.host');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        
        // Connect to MySQL server directly (without selecting a DB)
        try {
            $pdo = new \PDO("mysql:host=$host", $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->error("Could not connect to MySQL server: " . $e->getMessage());
            $this->error("Please check your DB_HOST, DB_USERNAME, and DB_PASSWORD in your .env file.");
            return false;
        }

        $databases = [
            config('database.connections.mysql.database'), // support_system
        ];

        // Add support databases
        foreach (Ticket::$typeConnectionMap as $connectionName) {
            $dbName = config("database.connections.$connectionName.database");
            if ($dbName) {
                $databases[] = $dbName;
            }
        }

        $databases = array_unique($databases);

        foreach ($databases as $dbName) {
            $this->info("Checking database: $dbName");
            $query = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $pdo->exec($query);
        }

        return true;
    }

    protected function runMigrations()
    {
        $this->info('Running migrations...');

        // Migrate default connection
        $this->info('Migrating default connection...');
        $this->call('migrate', ['--force' => true]);

        // Migrate other connections
        // We need to migrate the 'tickets' table to all support databases
        // Since we created a single migration file for tickets, running migrate on other connections
        // will attempt to run all migrations. 
        // Ideally, we should only run the tickets migration, but for simplicity we can run all.
        // However, 'users' table might not be needed in other DBs.
        // But it doesn't hurt to have them.

        foreach (Ticket::$typeConnectionMap as $connectionName) {
            $this->info("Migrating connection: $connectionName");
            $this->call('migrate', [
                '--database' => $connectionName,
                '--force' => true,
            ]);
        }
    }
}
