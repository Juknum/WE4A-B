# README

This project has been tested & developed using `XAMPP`, take the whole directory and place it in the `htdocs` directory, then launch the `XAMPP Control Panel` with **Apache** & **MySQL** started. 

## Save data

Save data without **phpmyadmin**:

```bsh
mysqldump -u root --default-character-set=utf8 we4a > ./database.sql
```
> ⚠️ Windows: Be sure to have the `bin` folder of your MySQL install in your PATH

## Install Information

This project is ran with the followings versions:

| Tool  |     Version     |
|:-----:|:---------------:|
|  PHP  |      8.1.4      |
| MySQL | 10.4.24-MariaDB |
