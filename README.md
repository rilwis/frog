# Frog - A new way to debug in PHP

There are situations where you want to show information of variables in PHP. While `print_r`, `var_dump` and `var_export` are common functions that you can use, they either output directly in your app which might affects the appearance or interrupt the process when using with `die`. It's even harder to debug when you work with Ajax or API.

Until Frog!

Frog creates a socket that always listen to debug requests and show the information about the variables it receives. It doesn't interrupt your process or output anything in your app. Instead it outputs data in the terminal and (optional) browser.

## Installation

Clone this repo

```
git clone https://github.com/rilwis/frog.git
```

Install the dependedencies with Composer

```
composer install
```

Start the socket server

```
php server.php
```

If you put Frog folder inside Lavarel Valet or inside any localhost, you can open it in the browser at `http://frog.test` (with Laravel Valet) or `http://localhost/frog/public/` (if you put Frog in your document root of localhost).

After that, Frog will listen to `1503` on `127.0.0.1`. Whenever you connect via socket and send data to Frog, it will display the data in the terminal.

If you open the browser, the debug info is automatically appears in the browser (without refreshing).

## Sending data to Frog

Currently, we support WordPress. To send debug data from WordPress to Frog, please see [`frog-wp`](https://github.com/rilwis/frog-wp) repo.
