<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MongoDB\Client;

/**
 * Create MongoDB indexes.
 */
class CreateMongoIndexes extends Command
{
    /**
     * Command signature.
     *
     * @var string
     */
    protected $signature = 'mongodb:indexes';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Create MongoDB indexes';

    /**
     * Execute command.
     */
    public function handle()
    {
        /**
         * Create MongoDB client connection.
         */
        $client = new Client(
            'mongodb://127.0.0.1:27017'
        );

        /**
         * Select active database.
         */
        $database = $client->selectDatabase(
            env('MONGODB_DATABASE')
        );

        /**
         * Create indexes for vital records.
         */
        $database
            ->vital_records
            ->createIndex([
                'user_id' => 1,
                'created_at' => -1,
                'status' => 1,
            ]);

        /**
         * Create indexes for users.
         */
        $database
            ->users
            ->createIndex([
                'email' => 1,
            ], [
                'unique' => true
            ]);

        $this->info(
            'MongoDB indexes created successfully.'
        );
    }
}