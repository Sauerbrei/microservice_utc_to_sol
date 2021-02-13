# Mars Time Converter Service
This project converts mars time to utc as a microservice.

PHP 7.4 installed is highly recommended.

## Execution
### Tests
    composer test

### start app
Install Symfony
https://symfony.com/download

    cd to/this/project
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
