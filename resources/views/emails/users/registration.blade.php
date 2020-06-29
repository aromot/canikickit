<p>Hello {{ $user->username }},</p>
<p>This message is sent to you as you registered. Please click on the link to confirm your account:</p>
<p>
  <a href="{{ $urlConfirm }}">{{ $urlConfirm }}</a>
</p>
<p>
Regards,<br>
The team.
</p>