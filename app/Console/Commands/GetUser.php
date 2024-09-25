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
    protected $signature = 'getUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to get user passwords and user details';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = UserModel::with('userPassword')->get();
        
        $this->info($users);
        if (!$users) {
            $this->error("Users dont exist");
            return;
        }

        foreach ($users as $user) {
            $this->info("User ID: " . $user->id);
            $this->info("Name: " . $user->name);
            $this->info("Profile Photo: " . $user->profilePic);
            $this->info("Address: " . $user->address);
            $this->info("Phone No: " . $user->phone);

            if ($user->userPassword && count($user->userPassword) > 0) {
                $this->info("
Passwords:");
                foreach ($user->userPassword as $password) {
                    $this->info("- $password->platform: " . $password->password);
                }
            } else {
                $this->info("Passwords: Not available");
            }

            $this->info("Created At: " . $user->created_at);
            $this->info("Updated At: " . $user->updated_at);
            $this->info("--------------------"); // Divider for clarity
        }

    }
}
