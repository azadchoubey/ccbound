<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'number' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'address' => ['required','string','max:255'],
            'country' => ['required'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email && $input['number'] !== $user->number) {
            // $this->updateVerifiedUser($user, $input);
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'hide_email' => $input['hide_email'],
                'number' => $input['number'],
                'hide_number' => $input['hide_number'],
                'country' => $input['country'],
                'state' => $input['state'],
                'city' => $input['city'],
                'address' => $input['address'],
                'email_verified_at' => null,
                'number_verified_at' => null,
            ])->save();
        }else if($input['email'] !== $user->email){
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'hide_email' => $input['hide_email'],
                'number' => $input['number'],
                'hide_number' => $input['hide_number'],
                'country' => $input['country'],
                'state' => $input['state'],
                'city' => $input['city'],
                'address' => $input['address'],
                'email_verified_at' => null,
            ])->save();
        }else if($input['number'] !== $user->number){
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'hide_email' => $input['hide_email'],
                'number' => $input['number'],
                'hide_number' => $input['hide_number'],
                'country' => $input['country'],
                'state' => $input['state'],
                'city' => $input['city'],
                'address' => $input['address'],
                'number_verified_at' => null,
            ])->save();
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'hide_email' => $input['hide_email'],
                'number' => $input['number'],
                'hide_number' => $input['hide_number'],
                'country' => $input['country'],
                'state' => $input['state'],
                'city' => $input['city'],
                'address' => $input['address'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'hide_email' => $input['hide_email'],
            'number' => $input['number'],
            'hide_number' => $input['hide_number'],
            'country' => $input['country'],
            'state' => $input['state'],
            'city' => $input['city'],
            'address' => $input['address'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
