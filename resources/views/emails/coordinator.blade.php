@component('mail::message')
# Idea Forum Coordinator

{{ $data['bodyMessage'] }}
<br>
<strong>Email:</strong> {{ $data['email'] }}
<br>
<strong>Password:</strong> {{ $data['password'] }}


Thanks,<br>
Idea Forum
@endcomponent
