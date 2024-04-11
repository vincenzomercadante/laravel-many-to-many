<x-mail::message>
    # {{ $project->title }} Created Succesfully

    Cheers {{ $user }}, {{ $project->title }} has just succesfully created!

    Click on the button below to see it

    <x-mail::button :url="$project_route">
        Go to Project
    </x-mail::button>

    Thanks,<br>
    The team of {{ config('app.name') }}
</x-mail::message>
