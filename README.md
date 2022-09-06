# Setup

1. Clone quick_admin repositpry.
   git clone https://github.com/yogesh-prajapati185/quick_admin.git

2. cd quick_admin

3. cp .env.example .env

4. define database, username, and password in .env file
   DB_DATABASE=quick_admin
   DB_USERNAME=root
   DB_PASSWORD=root
5. composer install
6. php artisan migrate --seed
7. default admin

    ### url: localhost:8000/login

    ### email: admin@admin.com

    ### password: 123456789

8. after login as per your requirement changes in App Setting

# Theme Setting:

### Changes in 2 file:

### loginHeader.blade.php & header.blade.php

### changes 2 things: inside if condition

if (themeURL == '' || projectName != '{{ config('app.name') }}') {
....
themeSet.themeURL = '{{ config('app.url') }}' + '/admin_assets/css/themes/cust-theme-13.css';
themeSet.themeOptions = 'mod-bg-1 mod-skin-light';
...
}
