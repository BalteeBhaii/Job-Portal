<x-mail::message>
# Introduction

Congratualtions! You are a premium user
<p>Your purchase details:</p>
<p>Plan: {{ $plan }}</p>
<p>Your plan ends: {{ $billingEnds }}</p>
<x-mail::button :url="''">
Job a job
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
