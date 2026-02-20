@if (auth()->user()->hasRole(['admin','recruiter']))

    @include('candidates.admin-recruiter.show')

@elseif(auth()->user()->hasRole(['candidate']))

    @include('candidates.candidate.show')

@endif
