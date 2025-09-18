<?php

class layouts {

    // Header + opening HTML
    public function header($conf) {
        ?>
        <!DOCTYPE html>
        <html lang="en" data-bs-theme="auto">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
            <meta name="generator" content="Astro v5.13.2">
            <title><?php echo $conf['site_name'] ?? 'My Site'; ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        </head>
        <body>
        <main>
        <?php
    }

    // Navbar always visible
    public function navbar($conf) {
        ?>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php"><?php echo $conf['site_name'] ?? 'My Site'; ?></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                                <li class="nav-item"><a class="nav-link" href="login.php">Sign In</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
        <?php
    }

    // Banner or main welcome area
    public function banner($conf, $page = 'home') {
        if ($page === 'home') {
            ?>
            <div class="p-5 mb-4 bg-body-tertiary rounded-3 text-center">
                <div class="container-fluid py-5">
                    <h1 class="display-3 fw-bold">Welcome to <?php echo $conf['site_name'] ?? 'My Site'; ?>!</h1>
                    <p class="col-md-8 fs-4 mx-auto">This is the home page. Use the navigation above to sign up or log in.</p>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="container py-4">
                <a href="index.php" class="btn btn-secondary mb-3">Go Back</a>
            <?php
        }
    }

    // Content area
    public function content($page = '', $ObjForms = null) {
        ?>
        <div class="container py-4">
            <?php
            if ($page === 'signup' && $ObjForms) {
                $ObjForms->signup();
            } elseif ($page === 'login' && $ObjForms) {
                $ObjForms->login();
            }
            ?>
        </div>
        <?php
        if ($page !== 'home') {
            echo '</div>'; // close container opened in banner()
        }
    }

    // Footer
    public function footer($conf) {
        ?>
        <footer class="pt-3 mt-4 text-body-secondary border-top">
            &copy; <?php echo date('Y'); ?> <?php echo $conf['site_name'] ?? 'My Site'; ?>
        </footer>
        </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
    }
}
