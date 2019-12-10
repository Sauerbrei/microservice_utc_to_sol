# Billie Mars Time Converter Service

PHP 7.4 installed is highly recommended.

Be aware, this is rather a coding-demo project,
than actually a full suite. So there might some unittests are missing.
I've added one, though. A full integration test is also included.

## Execution
### Tests
    composer test

### start app
Install Symfony
https://symfony.com/download

    cd to/this/project/billie_microservice
    symfony server:start


## Endpoints

    POST localhost:8000/api/convert/utc
    /** POST */
    { 'utc': 'Y-m-d\TH:i:sO' }

    /** Response */
    {
        'msd': <float>,
        'mtc': 'H:i:s'
    }

coded with <3
