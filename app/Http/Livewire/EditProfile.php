<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditProfile extends Component
{
  public $name;
  public $phoneNo;
  public $address;
  public $locationUrl;

  public $currentPassword;
  public $newPassword;
  public $newPassword_confirmation;

  protected $rules = [
    'name' => 'required|string|min:2',
    'phoneNo' => 'required|string|min:5',
    'address' => 'required|string|min:3',
    'locationUrl' => 'required|string',
  ];

  // Validation rules for password update
  public function passwordRules()
  {
    return [
      'currentPassword' => 'required|string|min:6',
      'newPassword' => 'required|string|min:6|confirmed',
    ];
  }

  // Set default values when the component is initialized
  public function mount()
  {
    $user = Auth::guard('vendors')->user(); // Get the authenticated user

    $this->name = $user->name;
    $this->phoneNo = $user->phoneNo; // Adjust based on your database column
    $this->address = $user->address;
    $this->locationUrl = $user->locationUrl;
  }

  public function editProfile()
  {
    // Validate the input fields
    $validatedData = $this->validate();

    // Update the user's profile
    $user = Auth::guard('vendors')->user();
    $user->update([
        'name' => $this->name,
        'phoneNo' => $this->phoneNo, // Adjust column name to match your database
        'address' => $this->address,
        'locationUrl' => $this->locationUrl,
    ]);

    // Provide feedback to the user
    session()->flash('success', trans('action.data_update_success'));
  }

  // Handle password update
  public function updatePassword()
  {
    $this->validate($this->passwordRules());

    $user = Auth::guard('vendors')->user();

    // Check if the current password is correct
    if (!Hash::check($this->currentPassword, $user->password)) {
      session()->flash('error', 'Current password is incorrect.');
      return;
    }

    // Update the password
    $user->update([
      'password' => Hash::make($this->newPassword),
    ]);

    // Clear the form fields
    $this->reset(['currentPassword', 'newPassword', 'newPassword_confirmation']);

    session()->flash('passwordSuccess', trans('action.password_update_success'));
  }



  public function render()
  {
    return view('livewire.edit-profile');
  }
}
