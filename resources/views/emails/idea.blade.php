@component('mail::message')
# Post Alert

{{ $data['bodyMessage'] }}

@component('mail::button', ['url' => $data["url"] ])
New Post
@endcomponent

#You can click here to see the post (Please Make sure you are Logged in.)
<a target="_blank" href="{{$data["url"]}}">{{ $data["url"] }}</a>

Thanks,<br>
Idea Forum
@endcomponent


