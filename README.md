# RentYourWilder
Install

    Clone this project
    Create .env.local and set DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8
    and MAILER_DSN=your_mailtrap_logs
    and MAILER_FROM_ADDRESS=contact@louetonwilder.com
    Run composer install
    Run yarn install
    Run yarn encore dev to build assets
    Run php bin/console d:d:c
    Run php bin/console d:m:m
    Run php bin/console doctrine:fixtures:load
    Run symfony server:start
