# Install & Run this environment:

Using VSCode is mandatory. You may run it without VSCode, but it is not explained below.  
Install [this VSCode Extension](https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver) and be sure to have at least `PHP 7.4.28` installed, then you can type `Ctrl + shift + P` and type `php project serve` to serve the actual directory into php. (use `stop server` to stop it)

You also needs [`MySQL`](https://dev.mysql.com/downloads/mysql/) (version 8.0.28)

## Required PHP extensions:
Those extensions needs to be added to your `php.ini` file (located next to your `php.exe` file)
- mysqli

> Be sure to also correctly setup the `extension_dir` field!

## MySQL:
Where `dbname` is the database name in MySQL & `database.sql` the filename

Import a MySQL database from file:
```bash
mysql -u root -p dbname < database.sql
```
Save a MySQL database to file:
```bash
mysqldump -u root -p -r dbname > database.sql
```
Create a database:
```bash
mysql -u root -p
```
```sql
mysql> CREATE DATABASE dbname;
```