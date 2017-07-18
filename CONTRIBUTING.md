# Zutto Contributor Guide

## Setup
Install dependencies & create an `.env` file:

      composer install
      composer run post-root-package-install

Don't forget to set the `APP_KEY' in the `.env` file. Any random 24-character string ought to do. You can generate one thusly:
    
    openssl rand -base64 24

Make sure you set the DB options in the `.env` file as well.

## Testing
Before submitting a pull request, ensure the tests still pass (and that you've added some, if applicable) and that your changes conform to the coding style standards:

    composer test
    composer cs-check

Most coding style standard violations can be automagically fixed:

    composer cs-fix
    composer cs-check

Try to keep the diffs clean so they're easy for us to review, please.
