@component('mail::message')
# Greetings

Congratulations!
<h1>welcome {{$user->name}} your account has been created</h1>
@component('mail::panel')
    Now just click the button below and reset your password
@endcomponent

@component('mail::button', ['url' => 'http://user-admin.test/password/reset'])
button
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
