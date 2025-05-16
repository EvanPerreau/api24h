<x-mail::message>
# Hello {{ $recipient->name }}!

## You need to verify your email address

### Please use the following code to verify your email address:

`{{ $code }}`
</x-mail::message>
