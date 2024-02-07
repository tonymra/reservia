Clone the repo locally:
git clone https://github.com/tonymra/reservia.git

cd reservia 

Install PHP dependencies:
composer install

### Install NPM dependencies:
npm install

### Build assets:
npm run dev

### Setup configuration:
cp .env.example .env

### Generate application key:
php artisan key:generate

### Create a MySQL database and update .env with the right credentials

### Run database migrations and seeders:

php artisan migrate:fresh --seed

### Run the development server:
php artisan serve

### Demo account details have been created which can be used to login

### Super Admin login Details: 

Email: admin@reservia.co.za Password: reservia

### Admin Login details: 

Email: admin1@reservia.co.za Password: reservia1

Email: admin2@reservia.co.za Password: reservia2

Email: admin3@reservia.co.za Password: reservia2
