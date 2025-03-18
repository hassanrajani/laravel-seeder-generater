# Laravel Seeder Generator

[![Latest Stable Version](https://poser.pugx.org/zainularfeen/laravel-seeder-generator/v/stable)](https://packagist.org/packages/zainularfeen/laravel-seeder-generator)
[![Total Downloads](https://poser.pugx.org/zainularfeen/laravel-seeder-generator/downloads)](https://packagist.org/packages/zainularfeen/laravel-seeder-generator)
[![License](https://poser.pugx.org/zainularfeen/laravel-seeder-generator/license)](https://packagist.org/packages/zainularfeen/laravel-seeder-generator)

Laravel Seeder Generator is a powerful package that allows you to generate **seeders from existing database tables** with hardcoded data. This is extremely useful for creating backups or replicating database states across different environments.

---

## 🚀 Features

✅ **Automatically generates seeders from database tables**  
✅ **Handles large datasets with chunking**  
✅ **Option to overwrite existing seeders**  
✅ **Efficient memory handling using Laravel's cursor**  
✅ **Easy installation and simple usage**  
✅ **Supports Laravel 9+**  

---

## 📦 Installation

You can install the package via Composer:

```sh
composer require zainularfeen/laravel-seeder-generator --dev
```

The package will be auto-discovered in Laravel. If not, you can manually register the Service Provider:

```php
// config/app.php
'providers' => [
    Zainularfeen\SeederGenerator\SeederGeneratorServiceProvider::class,
];
```

---

## ⚡ Usage

### **Generate Seeders for All Tables**
Run the following command to generate seeders for all database tables:

```sh
php -d memory_limit=-1 artisan generate:seeders
```

### **Custom Chunk Size**
If your database has a large number of records, you can control how many rows are processed at a time using the `--chunk` option:

```sh
php -d memory_limit=-1 artisan generate:seeders --chunk=500
```

### **Force Overwrite Existing Seeders**
By default, if a seeder file already exists, it will not be overwritten. Use `--force` to regenerate all seeders:

```sh
php -d memory_limit=-1 artisan generate:seeders --force
```

### **Combine Options**
You can combine options like this:

```sh
php -d memory_limit=-1 artisan generate:seeders --chunk=1000 --force
```

---

## 🛠️ How It Works
1. The command fetches all tables from the database.
2. It skips system tables like `migrations` and `telescope_entries`.
3. It reads all records using Laravel's `cursor()` to avoid memory issues.
4. Data is hardcoded into Laravel seeder files inside the `database/seeders` directory.
5. You can run `php artisan db:seed --class=YourTableSeeder` to seed your database.

---

## 📌 Example Output

After running the command, it generates seeder files inside `database/seeders`:

```php
<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
```

---

## 🔄 Running the Generated Seeders

Once the seeders are generated, you can use Laravel's built-in seeding commands:

```sh
php artisan db:seed --class=UsersSeeder
```

To seed all generated seeders at once:

```sh
php artisan db:seed
```

---

## 🔧 Troubleshooting

### **Seeder File Already Exists**
> ❌ "Seeder already exists for users. Use --force to overwrite."

**Solution:** Use the `--force` flag:
```sh
php artisan generate:seeders --force
```

### **Out of Memory Issues**
> ❌ "PHP Fatal error: Allowed memory size exhausted"

**Solution:** Run the command with unlimited memory:
```sh
php -d memory_limit=-1 artisan generate:seeders
```

---

## 🎯 License

This package is open-source software licensed under the [MIT license](LICENSE).

---

## 🤝 Contributing

Pull requests are welcome! If you find a bug or have a feature request, feel free to open an issue.

---

## 🏆 Credits

Developed by **Zain Ul Arfeen**  
Twitter: [@your_twitter_handle](https://twitter.com/your_twitter_handle)  
GitHub: [zainularfeen](https://github.com/zainularfeen)

