# Cash Center: Run and Mockery Guide

## What Mockery is

Mockery is a PHP test-double framework. It lets a test replace a real dependency
with a configurable object so the code under test can be checked in isolation.
It is installed in this project as a development dependency:

```json
"mockery/mockery": "^1.4.4"
```

The installed version is `1.6.12`. Mockery is not the application server and it
does not run the Cash Center UI. It is used by automated tests.

### Main concepts

- **Stub:** provides a known return value without checking how often it is used.
- **Mock:** defines expected calls, arguments, return values, and call counts.
- **Spy:** records calls so they can be inspected after the code runs.
- **Test double:** the general name for a fake object used instead of a real
  dependency during a test.

### Basic example

```php
use Mockery;
use PHPUnit\Framework\TestCase;

interface VaultRepository
{
    public function balance(int $vaultId): int;
}

final class CashServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_reads_the_vault_balance(): void
    {
        $repository = Mockery::mock(VaultRepository::class);
        $repository->expects()->balance(1)->andReturn(50000);

        $this->assertSame(50000, $repository->balance(1));
    }
}
```

`expects()` verifies that the method is called once with the specified argument.
Use `allows()` when only a return value matters:

```php
$repository->allows()->balance(1)->andReturn(50000);
```

Always close Mockery after each test. With PHPUnit, extending
`Mockery\Adapter\Phpunit\MockeryTestCase` or using the Mockery PHPUnit trait
can perform that cleanup automatically.

The file currently open in the editor,
`vendor/mockery/mockery/library/Mockery/Generator/StringManipulation/Pass/MagicMethodTypeHintsPass.php`,
is an internal Mockery code-generation pass. It preserves parameter and return
type hints when Mockery generates a double for a class or interface with magic
methods. Application code normally uses the public `Mockery::mock()`,
`allows()`, `expects()`, or `spy()` APIs instead of editing this file.

## Run the Cash Center application

Open PowerShell in the project directory:

```powershell
cd C:\xampp\htdocs\cash_center_v3
```

### First-time setup

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Configure the `DB_*` values in `.env`, then prepare the database:

```powershell
php artisan migrate --seed
php artisan storage:link
```

If the project does not have `database/database.sqlite`, create it before using
SQLite:

```powershell
New-Item database\database.sqlite -ItemType File
```

### Start the backend

```powershell
php artisan serve
```

Open <http://127.0.0.1:8000> in a browser. Keep this terminal running while
using the application.

### Start frontend assets

If the page needs Vite assets, use a second PowerShell window:

```powershell
cd C:\xampp\htdocs\cash_center_v3
npm install
npm run dev
```

For a production asset build, use:

```powershell
npm run build
```

## Run tests

This checkout currently has no `tests` directory or root `phpunit.xml`, so there
are no project tests to run yet. Once tests are added, run them with:

```powershell
php artisan test
```

or directly through PHPUnit:

```powershell
vendor\bin\phpunit
```

To add Mockery to another PHP project, install it as a development dependency:

```powershell
composer require --dev mockery/mockery
```

Documentation: <https://docs.mockery.io/>