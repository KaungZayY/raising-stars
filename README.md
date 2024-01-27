# Raising Stars

The University Student Portal is a role-based platform designed to streamline interactions among administrators, moderators, lecturers, and students. 

Each role comes with specific functionalities tailored to their responsibilities.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Contribution Guidelines](#contribution)
- [License](#license)

## Introduction
The University Student Portal is a comprehensive platform that facilitates communication and collaboration within the university community. 

It caters to four distinct roles, each contributing to the efficient functioning of the educational ecosystem.

## Features

### Admin Role
- Can manage users
- Create courses
- Schedule courses
- Manage user groups
- Approve student registration forms

### Moderators
- Manage user groups
- Maintain discussion forums

### Lecturers
- Answer the students' discussion posts

### Students
- Apply for course
- Join the group and start discussion
- Participate in group
- Check applied courses
- Check the status of registration forms

## Contribution

### ERD Diagram
- [Entity Relationship Diagram](https://lucid.app/lucidchart/7457bcbb-386b-44af-bbc4-3355107c634d/edit?invitationId=inv_8eefb750-5638-4bd0-b3f8-00613ea13638&page=0_0#)

### For Contribution & Testing

#### 1. Fork the Git Repository

- Click on the "Fork" button on the top-right corner of the repository page on GitHub.
- This creates a copy of the repository under your GitHub account.

#### 2. Clone the Git Repository

- Clone the repository to your local machine using the following command:

```bash
git clone https://github.com/your-username/repository-name.git
```

#### 3. Navigate to the Repository

```bash
cd repository-name
```

#### 4. Copy Env File

```bash
cp .env.example .env
```

#### 5. Install Composer

```bash
composer install
```

#### 6. Generate Key

```bash
php artisan key:generate
```

### Optional Docker Setup
---
#### 7. Install Docker Engine
- Install docker, refer to original [documentation](https://www.docker.com/products/docker-desktop/)

#### 8. Run Laravel Sail

- checkout laravel/sail [documentation](https://laravel.com/docs/10.x/sail)
- set sail alias
- run sail on detach mode

```bash
sail up -d
```
---
#### 9. Install Node Package Manager (npm)

- on sail environment

```bash
sail npm ci
```

- without sail

```bash
npm ci
```

#### 10. Run Local Server

- without sail

```bash
php artisan serve
```

#### 11. Run Node Package Manager

- on sail environment

```bash
sail npm run dev
```

- without sail

```bash
npm run dev
```

#### 12. Create Database and Run Migration

- on sail environment

```bash
sail artisan migrate
```

- without sail

```bash
php artisan migrate
```

#### 12. Seed Database

- on sail environment

```bash
sail artisan db:seed
```

- without sail

```bash
php artisan db:seed
```

### Default User Accounts

#### Admin Account
- **Username:** admin@gmail.com
- **Password:** 12345678

#### Moderator Account
- **Username:** moderator@gmail.com
- **Password:** 12345678

#### Student Account
- **Username:** student@gmail.com
- **Password:** 12345678

#### Lecturer Account
- **Username:** lecturer@gmail.com
- **Password:** 12345678

Feel free to use these default accounts to test and evaluate different features of the application. 

For security reasons, remember to update or remove these default accounts in a production environment.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT). 

See the official page for the terms and conditions.


