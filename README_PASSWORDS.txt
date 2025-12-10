After importing schema.sql, update password hashes for initial users.
Run PHP snippet to generate hash:
<?php
echo password_hash('adminpass', PASSWORD_DEFAULT);
?>
Then replace REPLACE_WITH_HASH in sql/schema.sql and re-import (or update the users table directly).
