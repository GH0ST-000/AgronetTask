# Agronnet Assigment
Small application built with Laravel, Vue.js and Tailwind.css <br>

## Installation
Make sure you have environment setup properly. You will need MySQL, PHP8.1, Node.js and composer.

### Install
1. Download the project (or clone using GIT)
2. Copy `.env.example` into `.env` and configure database credentials
3. Navigate to the project's root directory using terminal
4. Run `composer install`
5. Set the encryption key by executing `php artisan key:generate --ansi`
6. Run migrations and link `php artisan migrate ,php artisan storage:link`
7. Run Seeder `php artisan db:seed --class=AdminUserSeeder `
8. Start local server by executing `php artisan serve`
9. Open new terminal and navigate to the `backend` folder
10. Run `npm install`
11. Run `npm install`<br>
12. Copy `backend/.env.example` into `backend/.env`
13. Make sure `VITE_API_BASE_URL` key in `backend/.env` is set to your Laravel API host (Default: http://localhost:8000)
14. Run `npm run dev`
15. Copy vite server endpoint and open it browser
16. Default it is http://localhost:3000 and add it path /login to redirect login

