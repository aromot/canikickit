<p>Hello {{ $user->username }},</p>
<p>This message is sent to you as you seem to have lost your password. 
  Click on the following link to reset your password:</p>
<p>
  <a href="{{ $urlResetPass }}">{{ $urlResetPass }}</a>
</p>
<p>
Regards,<br>
The team.
</p>