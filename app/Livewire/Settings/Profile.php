<?php

namespace App\Livewire\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = "";
    public string $email = "";
    public string $phone = "";
    public string $address = "";
    public ?string $image = null;
    public $imageFile = null;
    public ?string $role = null;
    public ?string $account_state = null;
    public $language;

    public function toggleAccountState(): void
    {
        $this->account_state =
            $this->account_state === "Active" ? "Inactive" : "Active";

        $user = Auth::user();
        $user->account_state = $this->account_state;
        $user->save();

        $this->dispatch("account-state-updated", state: $this->account_state);
    }

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone ?? "";
        $this->address = Auth::user()->address ?? "";
        $this->image = Auth::user()->image ?? null;
        $this->role = Auth::user()->role ?? null;
        $this->account_state = Auth::user()->account_state ?? null;
        $this->language = Auth::user()->language ?? config("app.locale");
    }

    public function render()
    {
        return view("livewire.settings.profile", [
            "roles" => Role::orderBy("name", "asc")->get(),
        ]);
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $rules = [
            "name" => ["required", "string", "max:255"],
            "email" => [
                "required",
                "string",
                "lowercase",
                'regex:/^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                "max:255",
                Rule::unique(User::class)->ignore($user->id),
            ],

            "phone" => ["nullable", 'regex:/^\+[1-9]\d{10,19}$/'],
            "address" => ["nullable", "string", "max:255"],
            "imageFile" => ["nullable", "image", "max:2048"],
            "image" => ["nullable", "string", "max:255"],
            "account_state" => ["nullable", "string", "max:255"],
            "language" => "required|in:en,es",
        ];

        $messages = [
            "phone.regex" => __("validation.phone_format"),
            "email.regex" => __("validation.email_format"),
        ];

        $validated = $this->validate($rules, $messages);

        $oldLanguage = $user->language;

        if ($this->imageFile) {
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            $imagePath = $this->imageFile->store("users", "public");
            $validated["image"] = $imagePath;
        }

        $user->fill($validated);

        if ($user->isDirty("email")) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->imageFile = null;
        $this->image = $user->image;
        if ($this->image) {
            $this->dispatch(
                "profile-image-updated",
                url: Storage::url($this->image)
            );
        }

        session()->put("locale", $user->language);
        app()->setLocale($user->language);

        $this->dispatch(
            "profile-updated",
            name: $user->name,
            image: $user->image ? Storage::url($user->image) : ""
        );

        if ($oldLanguage !== $user->language) {
            $this->dispatch("reload-page");
        }
    }

    /**
     * Remove the uploaded image file.
     */
    public function removeImage(): void
    {
        $this->imageFile = null;
        $this->image = null;
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(
                default: route("dashboard", absolute: false)
            );

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash("status", "verification-link-sent");
    }

    public function removeProfileImage(): void
    {
        $user = Auth::user();

        if ($user->image && Storage::disk("public")->exists($user->image)) {
            Storage::disk("public")->delete($user->image);
        }

        $user->image = null;
        $user->save();

        $this->image = null;
        $this->imageFile = null;

        $this->dispatch("profile-updated", name: $user->name, image: "");
    }
}

