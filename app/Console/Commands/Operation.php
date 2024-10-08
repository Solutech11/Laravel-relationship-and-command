<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Operation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'perform crud on db';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        //get user
        $alluser= UserModel::all();

        if($alluser){
            $this->line('---------------------------------');
            foreach ($alluser as $user) {
                $this->info("id: {$user->id}, name: {$user->name}");
            }
            $this->line('---------------------------------
            ');

        }
        //
        $this->info("Select the command
- Select
- Update
- Delete
- Add");

        $operation = $this->choice(
            'Which operation would you like to perform?', 
            ['Select', 'Update', 'Delete', 'Add'], 
            0
        );

        if($operation=='Select'){
            $this->selectOperation();
        }else if($operation=='Update'){
            $this->updateOperation();
        }else if($operation=='Delete'){
            $this->deleteOperation();
        }else if($operation=='Add'){
            $this->addOperation();
        }
    }

    private function selectOperation()
    {
        $userId = $this->ask('Enter the user ID to update');
        $user = UserModel::with('userPassword')->where('id',$userId)->first();

        if ($user) {
            $this->info("Displaying all users:");
            $this->info("User ID: " . $user->id);
            $this->info("Name: " . $user->name);
            $this->info("Profile Photo: " . $user->profilePic);
            $this->info("Address: " . $user->address);
            $this->info("Phone No: " . $user->phone);

            if ($user->userPassword && count($user->userPassword) > 0) {
                $this->info("\nPasswords:");
                foreach ($user->userPassword as $password) {
                    $this->info("- $password->platform: " . $password->password);
                }
            } else {
                $this->info("Passwords: Not available");
            }

        } else {
            $this->error('User not found.');
        }

        
    }

    private function updateOperation()
    {
        // Example update operation logic
        $userId = $this->ask('Enter the user ID to update');
        $user = UserModel::where('id',$userId)->first();

        if ($user) {
            $newName = $this->ask('Enter the new name');
            $user->name = $newName?$newName:$user->name;

            $newAdress = $this->ask('Enter the new Address');
            $user->address = $newAdress?$newAdress:$user->address;

            $newPhone = $this->ask('Enter the new Phone number');
            $user->phone = $newPhone?$newPhone:$user->phone;

            $newpassword = $this->ask('Enter the new password');
            $user->password = $newpassword?Hash::make($newpassword):$user->password;

            $user->save();
            $this->info('User updated successfully.');
        } else {
            $this->error('User not found.');
        }
    }

    private function deleteOperation()
    {
        $userId = $this->ask('Enter the user ID to delete');
        $user = UserModel::with('userPassword')->where('id',$userId)->first();
    
        if ($user) {
            // Delete all related passwords first
            $user->userPassword()->delete();  // Deletes related passwords
            
            $user->delete(); // Then delete the user
            $this->info('User deleted successfully.');
        } else {
            $this->error('User not found.');
        }
    }    

    private function addOperation()
    {
        // Example add operation logic
        $nameuser = $this->ask('Enter the user name');
        $address = $this->ask('Enter the user address');
        $phone = $this->ask('Enter the user phone');
        $password = Hash::make($this->ask('Enter the user password'));
        $Photo = Hash::make($this->ask('Enter the user Profile Photo link'));

        UserModel::create([
            'name' => $nameuser,
            'address' => $address,
            'phone' => $phone,
            'password' => $password,
            'profilePic'=>$Photo
        ]);

        $this->info('User saved successfully.');
    }
}
