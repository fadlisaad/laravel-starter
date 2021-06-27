@component('mail::message')
# Hello {{ $shop->person_in_charge }},
## Welcome to CartSitu team!

Thank you for joining us. While you can continue managing your shop from the mobile app, we still require some information in order to make your journey with us more enjoyable. Use the button below to access your mechant dashboard from any web browser.

You can login to the dashboard by using the below details for registration:

**E-mail: {{ $shop->email }}**  
(Please make sure to use this e-mail address so we can automatically match your account to your shop)

@component('mail::button', ['url' => $url])
Register
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
This message is sent to you because you have register with us. If you received this email wrongly, please notify us at **{{ env('MAIL_FROM_ADDRESS') }}**. To continue receive email from us, please add this email address to your safe email sender list.
@endcomponent

@endcomponent