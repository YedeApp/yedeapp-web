<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(10)->make();
        
        // Make sure user hidden fields are visible, so they can be manipulated
        // and be put into an array.
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($user_array);

        // foreach ($users as $user) {
        //     $user->save();
        // }

        // Change the first user's data
        $user = User::find(1);
        $user->name = 'Yede';
        $user->email = 'yedeapp@163.com';
        $user->phone = '18129835206';
        $user->avatar = 'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200';
        $user->save();
        // $user->assignRole('Superadmin');        

        // $user = User::find(2);
        // $user->assignRole('Admin');

        // $user = User::find(3);
        // $user->assignRole('Writer');

        // $user = User::find(4);
        // $user->assignRole('Subscriber');
    }
}
