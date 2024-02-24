# Studymate
Simple study information system where teachers can create modules and assign students. Afterwards, students can submit tests to earn their studypoints. Written in PHP using the Laravel framework.

## Prerequisites
- PHP >= 7.4
- Composer
- Nodejs/NPM
- Mysql

## Getting Started
1. Clone this project.
2. Copy the `.env.example` and rename it to `.env`.
3. Fill in your credentials.
4. Run `composer install`.
5. Run `npm run watch` or `npm run dev`.
6. Run `php artisan migrate --seed`.
7. Run `php artisan key:generate`.
8. Run `php artisan serve` (if you are on mac, you can use [Laravel valet](https://laravel.com/docs/6.x/valet)).
8. Enjoy! :tada:

## Coding guidelines
This project uses PHP PSR1,PSR2 and PSR4. 
When using phpstorm please import our coding scheme (`Studymate-codingstyle.xml`) into the ide. 

## Design patterns
| Category      | Pattern                              | Location                                         |
| ------------- |--------------------------------------| -------------------------------------------------|
| Behavioral    | Visitor                              | `app\Http\Controllers\DashboardController.php`   |
|               |                                      | `resources\views\layouts\navbar.blade.php`       |
|               | Strategy                             | `app\Traits\Encryptable.php`                     |
|               | Chain of Responsibility              | `app\Providers\AuthServiceProvider.php`          |
| Creational    | Factory                              | *                                                |
|               | Singleton                            | *                                                |
| Structure     | Facade                               | *                                                |

## Authors
- [Micha Nijenhof](https://github.com/killermi200)
- [Tjeu Foolen](https://github.com/tjeufoolen)
