<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bouncer;
use Silber\Bouncer\Database\Ability;

class SyncAbilitiesToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:sync:abilities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will sync all abilities to database and changes if necessary';

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
     * @return mixed
     */
    public function handle()
    {
        // Get all abilities from db
        $dbAbilities = Ability::all();

        // Get all abilities
        $abilities = config('custom.abilities');
        foreach ($abilities as $model => $info) {
            foreach ($info as $name => $id) {
                $this->interactWithAbility($model, $name, $id, $dbAbilities);
            }
        }
    }

    protected function interactWithAbility($model, $name, $id, $dbAbilities)
    {
        $exploded_model = explode('\\', $model);
        $namePostfix = strtolower(end($exploded_model));
        $fullName = $name . '-' . $namePostfix;
        $title = ucwords(str_replace('-', ' ', $fullName));

        // First find out if ability already exists
        $abil = $dbAbilities->where('name', $fullName)
            ->where('entity_type', $model)
            ->where('id', $id)
            ->first();

        // If this exact type of ability is already in DB then we are done!
        if ($abil) {
            return true;
        }

        // Delete if exists
        if ($dbAbilities->where('id', $id)->isNotEmpty()) {
            Ability::find($id)->delete();
        }

        // Now we are ready to insert
        $ability = new Ability;
        $ability->id = $id;
        $ability->name = $fullName;
        $ability->title = $title;
        $ability->entity_type = $model;
        $ability->save();

        // Attach to Admin
        Bouncer::allow('admin')->to($ability);
    }
}
