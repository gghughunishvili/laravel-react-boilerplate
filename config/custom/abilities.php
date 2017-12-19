<?php

use Ability;
use App\Models\User;
use Role;

/*
|--------------------------------------------------------------------------
| All Abilities
|--------------------------------------------------------------------------
|
| Here will be listed all the abilities that app will use.
| This abilities will be attached to admin when command will run
| A name always must be separated by dashes
| In project exists command sync:abilities that will sync all abilities to db,
| and it will create title by itself if not provided,
|
*/

$abilities = [];

// Ability
$abilityClass = Ability::class;

$abilities[$abilityClass]['create'] = 1;
$abilities[$abilityClass]['update'] = 2;
$abilities[$abilityClass]['find'] = 3;
$abilities[$abilityClass]['give'] = 4;

// Role
$roleClass = Role::class;

$abilities[$roleClass]['create'] = 5;
$abilities[$roleClass]['update'] = 6;
$abilities[$roleClass]['delete'] = 7;
$abilities[$roleClass]['find'] = 8;
$abilities[$roleClass]['give'] = 9;

// User
$userClass = User::class;

$abilities[$userClass]['create'] = 10;
$abilities[$userClass]['update'] = 11;
$abilities[$userClass]['delete'] = 12;
$abilities[$userClass]['find'] = 13;
