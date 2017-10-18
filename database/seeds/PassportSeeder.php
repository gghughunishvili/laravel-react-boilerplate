<?php

use Illuminate\Database\Seeder;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->truncate();
        $exitCode = Artisan::call('passport:install');

        DB::table('oauth_clients')
            ->where('id', config('main.seeder.passport.client_id'))
            ->update([
                'secret' => config('main.seeder.passport.client_secret'),
                'personal_access_client' => 1,
                'password_client' => 1,
                'name' => "Laravel Based REST-API Personal Access and Password Client General"
            ]);

        DB::table('oauth_clients')
            ->where('id', 2)
            ->update([
                'secret' => "CzS929hBoCg8Ynb1AEFj4urqlG4ueb3xT41YllMA",
                'personal_access_client' => 1,
                'password_client' => 1,
                'name'=> "Laravel Based REST-API Personal Access and Password Client For Specific User"
            ]);
    }
}
