<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;

class GetUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getUser {page=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to get user passwords and user details with pagination';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the page number from the command argument, default is 1
        $page = $this->argument('page');

        // Set how many users to display per page
        $perPage = 10;

        // Fetch users with pagination
        $users = UserModel::with('userPassword')->paginate($perPage, ['*'], 'page', $page);

        // Check if users exist
        if ($users->isEmpty()) {
            $this->error("No users found on page $page.");
            return;
        }

        // Display the users
        foreach ($users as $user) {
            $this->info("User ID: " . $user->id);
            $this->info("Name: " . $user->name);
            $this->info("Profile Photo: " . $user->profilePic);
            $this->info("Address: " . $user->address);
            $this->info("Phone No: " . $user->phone);

            if ($user->userPassword && $user->userPassword->isNotEmpty()) {
                $this->line("Passwords:");
                foreach ($user->userPassword as $password) {
                    $this->info("- " . $password->platform . ": " . $password->password);
                }
            } else {
                $this->info("Passwords: Not available");
            }

            $this->info("Created At: " . $user->created_at);
            $this->info("Updated At: " . $user->updated_at);
            $this->line("--------------------"); // Divider for clarity
        }

        // Show pagination info
        $this->info("Page " . $users->currentPage() . " of " . $users->lastPage());
        $this->info("Showing " . $users->count() . " users out of " . $users->total() . " total users.");
    }
}

