@if (auth()->user()->hasRole(['admin','recruiter']))

    @include('candidates.admin-recruiter.edit')

@elseif(auth()->user()->hasRole(['candidate']))

    @include('candidates.candidate.edit')

@endif
