# Zutto Contributor Guide
To set Zutto up, install `phpunit`:

  composer global require phpunit/phpunit
  composer global require phpunit/dbunit

Then, create a `.env` file and grab the dependencies:

      composer install
      composer run post-root-package-install

Don't forget to set the `APP_KEY' in the `.env` file. Any random 24-character string ought to do. You can generate one thusly:
    
    openssl rand -base64 24

Make sure you set the DB options in the `.env` file as well.
