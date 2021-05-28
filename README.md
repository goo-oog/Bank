# Tiny Bank

With this bank simulator, you can open accounts in multiple currencies and perform money transactions with automatic
currency conversion. Also, it is possible to create an investment account and start trading stocks. If you were lucky in
stock exchange and had to pay the capital gains tax, "tinY Bank" has got you covered! Application features full-scale
two-factor authentication powered by Laravel Jetstream.

<img src="https://www.dropbox.com/s/tx296snj2ksdqxn/Bank1.png?raw=1">

<img src="https://www.dropbox.com/s/25942xwgl7jhswn/Bank2.png?raw=1">

### Setup

From the root folder run:

    composer install

Create database and write its name, username and password in '.env' file:

    DB_DATABASE=your_dabase_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

Go to [Finnhub](https://finnhub.io/), register and get the access token. Then fill it in '.env' file:

    FINNHUB_TOKEN='your_token'

Fill all `MAIL` section in '.env' file.

If needed, change your time zone in '.env' file:

    APP_TIMEZONE=UTC

Run migrations:

    php artisan migrate

Start the queue worker:

    php artisan queue:work

Open new terminal and start the server:

    php artisan serve