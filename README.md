<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About this project

This is a full-stack project built with TALL stack solution. The purpose of this project is to be able to create a user admin system, where you can create/edit a user and assign a role to a user. The system also sends an email when a user logs in with a new IP or device/browser. The project also includes resources like policies, REST API, TDD and Laravel Mail.

## Steps to run the project

- First, make a clone of the project to your computer:
```bash
git clone git@github.com:janaina2jsantos/plus_narrative.git
```
- Create a database named `plusnarrative` or whatever name you prefer.
- Run the migrations and the seeders:
```bash
php artisan db:seed --class=RoleSeeder

```
```bash
php artisan db:seed --class=UserSeeder

```
- Choose one of the records in the users table in order to access the dashboard.
- You can use Mailtrap/Mailhog to verify email notifications that must be sent every time a new login has been made from a new browser/device.
- Enjoy the project!

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
