<?php

use App\Models\Employer;
use App\Models\Job;

it('belongs to an employer', function () {
//    Testing is a 3-step process:
//    arrange - arrange the world in order to run
    $employer = Employer::factory()->create();
    $job = Job::factory()->create([
        'employer_id' => $employer->id
    ]);

//    act - perform the action
    $jobEmployer = $job->employer;

//    assert - what did you expect to happen as a result of that assertion
    expect($jobEmployer->is($employer))->toBeTrue();
});

it('can have tags', function() {
   //AAA
    $job = Job::factory()->create();

    $job->tag('Frontend');

    expect($job->tags)->toHaveCount(1);
});
