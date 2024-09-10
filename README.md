# Laravel Multiple Authentication System

This Laravel project showcases a multiple authentication system designed to cater to two distinct user types: admins and employees. With this system, users can seamlessly navigate through their respective modules, each tailored to their unique needs.

## Features

- **Admin Module**: Admins enjoy elevated privileges, including:
  - User management: CRUD operations on users.
  - Role-based access control (RBAC): Assigning roles and permissions to users.

- **Employee Module**: Employees have access to functionalities such as:
  - Employee directory: Viewing and managing employee profiles.
  - Time tracking: Recording and managing work hours.

## Installation

<h3>1.Install dependencies:</h3>
composer install

<h3>2.Set up environment variables by renaming .env.example to .env and configuring the necessary database settings.</h3>

<h3>3.Generate application key:</h3>
php artisan key:generate

<h3>4.Migrate the database:</h3>
php artisan migrate

<h3>5.Serve the application:</h3>
php artisan serve


<h3>Usage</h3>
Admin Authentication: Access the admin module by registering as an admin or using the default admin credentials.
Employee Authentication: Similarly, access the employee module by registering as an employee or using predefined employee credentials.
