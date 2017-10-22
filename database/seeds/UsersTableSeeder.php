<?php

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin User
        $admin = (object) config('main.seeder.admin');
        $user = User::find($admin->id);
        if (!$user) {
            $user = new User;
            $user->id = $admin->id;
        }
        $user->fill([
            'name' => $admin->name,
            'email' => $admin->email,
            'username' => 'admin',
            'password' => bcrypt($admin->password),
            'status' => 'active',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $user->save();

        // Test User
        $test = (object) config('main.seeder.test');
        $user = User::find($test->id);
        if (!$user) {
            $user = new User;
            $user->id = $test->id;
        }
        $user->fill([
            'name' => $test->name,
            'email' => $test->email,
            'username' => 'test',
            'password' => bcrypt($test->password),
            'status' => 'active',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $user->save();

        // Testing User Passive
        $user = User::find("1ab925c1-fd55-4ceb-ac1d-2d09bdbef049");
        if (!$user) {
            $user = new User;
            $user->id = "1ab925c1-fd55-4ceb-ac1d-2d09bdbef049";
        }
        $user->fill([
            'name' => Faker::create()->name,
            'email' => 'passive@example.com',
            'username' => 'passive',
            'password' => bcrypt('123456'),
            'status' => 'passive',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $user->save();

        // Testing User Pending
        $user = User::find("3ead8367-ba50-4f72-bc33-aca95fcdd0d1");
        if (!$user) {
            $user = new User;
            $user->id = "3ead8367-ba50-4f72-bc33-aca95fcdd0d1";
        }
        $user->fill([
            'name' => Faker::create()->name,
            'email' => 'pending@example.com',
            'username' => 'pending',
            'password' => bcrypt('123456'),
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $user->save();

    }
}
