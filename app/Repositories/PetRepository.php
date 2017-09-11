<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Pet;
use App\Models\PetType;
use App\Models\PetSkin;
use App\Models\PetSkill;
use App\Services\RollService;
use Illuminate\Support\Facades\DB;

class PetRepository extends BaseRepository
{
    public static function create(User $user, $petData, PetType $petType, PetSkin $petSkin = null)
    {
        if ($petSkin == null) {
            $petSkin = $petType->defaultSkin;
        }

        $rng = new RollService($petType->skillRollTable);
        $skills = $rng->roll()->getObjects();

        return DB::transaction(function () use ($user, $petData, $petType, $petSkin, $skills) {
            $pet = new Pet();
            $pet->name = $petData['name'];
            $pet->user()->associate($user);
            $pet->type()->associate($petType);
            $pet->skin()->associate($petSkin);
    
            $skills_save = [];
            foreach ($skills as $skill) {
                $mapping = new PetSkill();
                $mapping->skill()->associate($skill['object']);
                $mapping->bonus_percent = $skill['quantity'];

                $skills_save[] = $mapping;
            }

            $pet->save();
            $pet->skills()->saveMany($skills_save);

            // Reload for return
            $pet = Pet::details()->where('id', $pet->id)->first();

            return $pet;
        });
    } // end create

    public static function createNewUser($userData, $provider = 'native')
    {
        $password = User::hashPassword($userData['password']);

        // New users start with the basic resources.
        return DB::transaction(function () use ($provider, $userData, $password) {
            $user = new User();
            $user->auth_provider = $provider;
            $user->username = $userData['username'];

            $user->email = $userData['email'];
            $user->email_confirmed = false;
            $user->email_verify_token = bin2hex(random_bytes(32));

            $user->birth_date = $userData['birthDate'];
            $user->tos_accept = $userData['tosAccept'];

            $user->password_hash = $password['hash'];
            $user->password_salt = $password['salt'];

            $user->registered_ip = $userData['registered_ip'];
            $user->last_access_ip = $userData['last_access_ip'];

    
            $user->save();

            return $user;
        });
    } // end createNewUser

    public static function verifyEmail(User $user)
    {
        return DB::transaction(function () use ($user) {
            $user->email_verify_token = null;
            $user->email_confirmed = true;

            $user->save();

            return $user;
        });
    } // end verifyUser
} // end UserRepository
