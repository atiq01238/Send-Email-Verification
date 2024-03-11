@component('mail::message')
<p>Hello {{ $user->name }},</p>

<p>Welcome to our platform! Thank you for registering.</p>

@component('mail::button', ['url' => url('login' . $user->verification_token)])
    Verify Email
@endcomponent

<p>If you have any questions, feel free to contact us.</p>
@endcomponent
