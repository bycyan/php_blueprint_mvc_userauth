1. koppeltabel aanmaken "user_roles"
2. tabel aanmaken "roles"
3. na user authenticatie (login) rol ophalen: getUserRol($id)

4. Controller en View implementatie

**Access Control** op Controller laag. bijvoorbeeld een editAction()

```php
//In your controllers, check the user's role before allowing access to certain actions.

// Example check in a controller method
public function editAction() {
    if ($_SESSION['user_role'] !== 'admin') {
        // Redirect or show an error message
        die("You do not have permission to perform this action.");
    }

    // Continue with the edit action
}
```

**View Logic** op View laag. Bijvoorbeeld een button laten zien

```php
// Example in a view file
<?php if ($_SESSION['user_role'] === 'admin'): ?>
    <button>Edit</button>
<?php endif; ?>
```

5. Pas proberen als het bovenste lukt

**Middleware** checks user roles before processing the request.

```php
// Example middleware
class AdminMiddleware {
    public function handle($request) {
        if ($_SESSION['user_role'] !== 'admin') {
            // Redirect or show an error message
            die("You do not have permission to perform this action.");
        }
    }
}
```

Apply middleware to routes that require admin access.

```php
// Example route definition with middleware
$router->add('/admin/edit', ['AdminController', 'editAction'], ['AdminMiddleware']);
```
