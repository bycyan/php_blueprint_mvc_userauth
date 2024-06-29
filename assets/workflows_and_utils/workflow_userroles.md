# workflow_userroles

1. koppeltabel aanmaken "user_roles"
2. tabel aanmaken "roles"
3. na user authenticatie (login) rol ophalen: getUserRol($user_id)

```php
// After successful login. De functie getUserRole aanmaken in controller
$_SESSION['user_role'] = getUserRole($user_id);
```

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

5. **op request niveau** (Pas implementeren als het bovenste lukt!!)

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

6. **permissions**

### add permissions to "roles" table

```sql
INSERT INTO permissions (name) VALUES
    ('view_content'),
    ('add_content'),
    ('edit_content'),
    ('delete_content');
```

- logged-in user can: view_content, edit own information, delete account
- a admin can: all of users permission +

niet ingelogd == 0
user == level 1
admin == level 100

per pagina kijken welk niveau er binnenkomt. als de waarde groter is dan 0 is het niet meer nodig om login en register te tonen.

Tot nu toe:

- User tabel toegevoegd aan database. als user wordt geregistreerd is het automatisch een user. ENUM user en admin
- is de Session waar de userrole === aan user > laat iets zien

Stappenplan

- een admin ziet een dashboard/lijst(home) >> get all users in user controller met alle gebruikers >> filter op view (alleen de admin krijgt een lijst anders alleen de gebruikers tonen)
- alleen de admin kan deze aanpassen en verwijderen (update and delete user toevoegen) >> filer op userController
- knoppen roepen dus functie delete en update aan

1.
