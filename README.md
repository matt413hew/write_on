# Write_on
A simple write/editor dashboard


To run the system please ensure the following are included in your system
1. Composer
2. NodeJs
3. NPM
4. MySql 
5. PHP 8.x
6. VS Code - Developement

## Database
Make sure to have a database with the name 'writeon'

## API
1. cd api
2. composer update (or composer install)
3. setup .env file (if .env file does not exist use env.example file)
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed
8. php artisan serve

## CLIENT

1. cd client
2. npm install 
3. npm run dev


## Sample Credentials

### WRITER
username: writer
password: writerpass

### EDITOR
username: editor
password: editorpass
